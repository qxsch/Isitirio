<?php
namespace Isitirio\Workflow;

use Isitirio\Yaml,
    DomainException,
    Traversable,
    Isitirio\Workflow\Lists\TriggerList,
    Isitirio\Workflow\Triggers\ValidatorTriggers,
    Isitirio\Workflow\Triggers\BeforeTriggers,
    Isitirio\Workflow\Triggers\AfterTriggers;

class WorkflowRegistryBuilder {
	private $yaml;
	private $clearRegistry;
	private $workflows = array();
	private $appliedTicketTypes = array();
	private $useClasses = array();

	protected function __construct(Yaml $yaml, bool $clearRegistry) {
		$this->yaml = $yaml;
		$this->clearRegistry = $clearRegistry;
	}

	public function getYaml() {
		return $this->yaml;
	}

	public function isClearRegistry() {
		return $this->clearRegistry;
	}

	public function build() {
		$this->clearWorkflowCache();

		foreach($this->yaml as $workflowname => $workflowconf) {
			if(!($workflowconf instanceof Yaml)) {
				throw new DomainException('The workflow with name "' . $workflowname . '" does not have a valid configuration.');
			}
			if(!isset($workflowconf['AppliesToTicketTypes'])) {
				throw new DomainException('The workflow with name "' . $workflowname . '" does not have a valid AppliesToTicketTypes configuration.');
			}
			if(!isset($workflowconf['InitialState'])) {
				throw new DomainException('The workflow with name "' . $workflowname . '" does not have a valid InitialState.');
			}

			$this->prepareUseClasses($workflowconf);

			$workflow = new Workflow($workflowname, (string) $workflowconf['InitialState']);
			$this->pushWorkflowCache($workflow, $workflowconf['AppliesToTicketTypes']);

			if(!isset($workflowconf['Transitions']) || !($workflowconf['Transitions'] instanceof Yaml)) {
				throw new DomainException('The workflow with name "' . $workflowname . '" does not have a valid Transitions configuration.');
			}
			$this->pushTransitionsToWorkflow($workflowconf['Transitions'], $workflow);

			$this->configureWorkflow($workflowconf, $workflow);
		}

		$this->commitToRegistry();
	}

	protected function commitToRegistry() {
		// form here we can clear the registry, if requested
		if($this->clearRegistry) {
			WorkflowRegistry::clearWorkflows();
		}

		// set the workflows
		foreach($this->yaml as $workflowname => $workflowconf) {
			WorkflowRegistry::addWorkflow($this->workflows[$workflowname], $this->sanitizeAppliedTicketTypes($workflowconf['AppliesToTicketTypes']));
		}
	}

	protected function configureWorkflow(Yaml $yaml, Workflow $workflow) {
		// for future workflow configuration tasks
	}

	protected function pushTransitionsToWorkflow(Yaml $yaml, Workflow $workflow) {
		$transitions = $workflow->getTransitions();
		foreach($yaml as $fromTransition => $subYaml) {
			if(!($subYaml instanceof Yaml)) {
				throw new DomainException('The workflow with name "' . $workflow->getName() . '" does not have a valid Transition configuration for From "' . $fromTransition . '".');
			}
			foreach($subYaml as $toTransition => $transitionConf) {
				if(!($transitionConf instanceof Yaml)) {
					throw new DomainException('The workflow with name "' . $workflow->getName() . '" does not have a valid Transition configuration for From "' . $fromTransition . '" and To "' . $toTransition . '".');
				}
				if(!isset($transitionConf['Name'])) {
					throw new DomainException('The workflow with name "' . $workflow->getName() . '" does not have a valid Transition configuration for From "' . $fromTransition . '" and To "' . $toTransition . '". (Name is missing.');
				}

				$trans = new Transition((string)$transitionConf['Name'], (string)$fromTransition, (string)$toTransition);

				foreach(array('BeforeTriggers' => $trans->getBeforeTriggers(), 'AfterTriggers' => $trans->getAfterTriggers(), 'ValidationTriggers' => $trans->getValidationTriggers()) as $key => $triggerlist) {
					if(!isset($transitionConf[$key])) continue;
					if(!($transitionConf[$key] instanceof Yaml)) {
						throw new DomainException('The transition "' . $transitionConf['Name'] . '" of workflow "' . $workflow->getName() . '" does not have a valid ' . $key . ' Configuration.');
					}
					try {
						$this->pushTriggersToTransition($transitionConf[$key], $triggerlist);
					}
					catch(DomainException $e) {
						throw new DomainException('The transition "' . $transitionConf['Name'] . '" of workflow "' . $workflow->getName() . '" does not have a valid ' . $key . ' Configuration. (' . $e->getMessage() . ')', 0, $e);
					}
				}
				$transitions->push($trans);
			}
		}
	}

	protected function pushTriggersToTransition(Yaml $yaml, TriggerList $triggerlist) {
		foreach($yaml as $triggerConf) {
			if(!($triggerConf)) {
				throw new DomainException('Missing trigger configuration.');
			}
			$array = $triggerConf->toArray();
			if(isset($array['InjectorCall']) && isset($array['Call'])) {
				throw new DomainException('You cannot use InjectorCall and Call in your trigger configuration.');
			}
			if(isset($array['InjectorCall'])) {
				$method = $this->resolveMethod($array['InjectorCall']);
				unset($array['InjectorCall']);
				$trigger = call_user_func($method, $array);
				if(!($trigger instanceof Trigger)) {
					throw new DomainException('The injector did not return a Trigger object.');
				}
				$triggerlist->push($trigger);
			}
			elseif(isset($array['Call'])) {
				$method = $this->resolveMethod($array['Call']);
				unset($array['Call']);
				$triggerlist->push(new Trigger($method, $array));
			}
			else {
				throw new DomainException('You have to use either InjectorCall or Call in your trigger configuration.');
			}
		}
	}


	private function prepareUseClasses(Yaml $yaml) : void {
		$this->useClasses = array();
		if(!isset($yaml['UseClasses']) || !($yaml['UseClasses'] instanceof Yaml)) {
			return;
		}
		foreach($yaml['UseClasses'] as $classPath) {
			$className = explode('\\', $classPath);
			$className = array_pop($className);
			if(isset($this->useClasses[$className])) {
				throw new DomainException('You have an UseClass definition conflict ("' . $this->useClasses[$className] . '" vs "' . $classPath . '").');
			}
			$this->useClasses[$className] = $classPath;
		}
		
	}

	protected function resolveMethod($method) {
		if(is_array($method)) {
			$m = array_shift($method);
			if(isset($this->useClasses[$m])) $m = $this->useClasses[$m];
			array_unshift($method, $m);
		}
		elseif(is_string($method)) {
			$a = explode('::', $method, 2);
			$m = array_shift($a);
			if(isset($this->useClasses[$m])) $m = $this->useClasses[$m];
			array_unshift($a, $m);
			$method = implode('::', $a);
		}
		if(!is_callable($method)) {
			throw new DomainException('The method is not callable.');
		}
		return $method;
	}

	protected function clearWorkflowCache() {
		$this->appliedTicketTypes = array();
		$this->workflows = array();
	}

	private function sanitizeAppliedTicketTypes($appliedTicketTypes) : array {
		$tt = array();
		if($appliedTicketTypes instanceof Traversable || is_array($appliedTicketTypes)) {
			foreach($appliedTicketTypes as $val) {
				$tt[] = (string) $val;
			}
		}
		else {
			$tt[] = (string) $t;
		}
		return $tt;
	}

	protected function pushWorkflowCache(Workflow $workflow, $appliedTicketTypes)  {
		// Ticket Types exist?
		foreach($this->sanitizeAppliedTicketTypes($appliedTicketTypes) as $t) {
			if(!$this->clearRegistry) {
				if(WorkflowRegistry::hasWorkflowByTicketType($t)) {
					throw new OutOfRangeException('The TicketType "' . $t . '" does already exist. (See Workflows "' . $workflow->getName() . '" and "' .WorkflowRegistry::getWorkflowByTicketType($t)->getName() . '"!)');
				}
			}
			if(isset($this->appliedTicketTypes[$t])) {
				throw new OutOfRangeException('The TicketType "' . $t . '" does already exist. (See Workflows "' . $workflow->getName() . '" and "' .$this->appliedTicketTypes[$t]->getName() . '"!)');
			}
			$this->appliedTicketTypes[$t] = $workflow;
		}

		if(!$this->clearRegistry) {
			if(WorkflowRegistry::hasWorkflowByName($workflow->getName())) {
				throw new OutOfRangeException('The workflow with name "' . $workflow->getName() . '" does already exist.');
			}
		}
		if(isset($this->workflows[$workflow->getName()])) {
			throw new OutOfRangeException('The workflow with name "' . $workflow->getName() . '" does already exist.');
		}
		$this->workflows[$workflow->getName()] = $workflow;
	}

	public static function buildFromArray(array $configuration, bool $clearRegistry=false) : void {
		self::buildFromYaml(Yaml::createFromArray($configuration), '', $clearRegistry);
	}

	public static function buildFromYaml(Yaml $yaml, string $yamlQuery='', bool $clearRegistry=false) : void {
		if($yamlQuery!='') {
			$yaml = $yaml->get($yamlQuery);
		}

		(new WorkflowRegistryBuilder($yaml, $clearRegistry))->build();
	}
}

