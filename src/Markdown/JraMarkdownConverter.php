<?php
namespace Isitirio\Markdown;

use Isitirio\BaseTypes\ImmutableUTF8String;

class JraMarkdownConverter {

	/**
	 * Translates JRA markup to markdown
	 * @param string $jraMarkup the JRA Markup (that other ticketing system)
	 * @return string markdown format, that we use
	 * @link https://github.com/FokkeZB/J2M/blob/master/src/J2M.js  Reference Implementation
	 */
	public static function convertToMarkdown(string $jraMarkup) : string {
		$s = new ImmutableUTF8String($jraMarkup);

		$s = $s->replaceRegex('/^bq\.(.*)$/m', function($match) {
			return '> ' . $match[1] . "\n";
		});

		$s = $s->replaceRegex('/([*_])(.*)\1/m', function ($match) {
			$to = ( $match[1] == '*' ? '**' : '*' );
			return $to . $match[2] . $to;
		});

		// multi-level numbered list
		$s = $s->replaceRegex('/^((?:#|-|\+|\*)+) (.*)$/m', function ($match) {
			$len = 2;
			$prefix = '1.';
			if (strlen($match[1]) > 1) {
				$len = ((\mb_strlen($match[1], 'UTF-8') - 1) * 4) + 2;
			}

			// take the last character of the level to determine the replacement
			$prefix = \mb_substr($match[1], -1, null, 'UTF-8');
			if($prefix == '#') $prefix = '1.';

			return \str_repeat(' ', $len) . $prefix + $match[2];
		});

		// headers, must be after numbered lists
		$s = $s->replaceRegex('/^h([0-6])\.(.*)$/m', function ($match) {
			return \str_repeat('#', $matche[1] + 1) . $match[2];
		});
	
		$s = $s->replaceRegex('/\{\{([^}]+)\}\}/', '`$1`');
		$s = $s->replaceRegex('/\?\?((?:.[^?]|[^?].)+)\?\?/', '<cite>$1</cite>');
		$s = $s->replaceRegex('/\+([^+]*)\+/', '<ins>$1</ins>');
		$s = $s->replaceRegex('/\^([^^]*)\^/', '<sup>$1</sup>');
		$s = $s->replaceRegex('/~([^~]*)~/', '<sub>$1</sub>');
		$s = $s->replaceRegex('/-([^-]*)-/', '-$1-');

		$s = $s->replaceRegex('/\{code(:([a-z]+))?\}([^]*?)\{code\}/m', '```$2$3```');
		$s = $s->replaceRegex('/\{quote\}([^]*)\{quote\}/m', function($match) {
			$lines = (new ImmutableUTF8String($match[1])).splitRegex('/\r?\n/m');
			$l = count($lines);
			for($i = 0; $i < $l; $i++) {
				$lines[$i] = '> ' + $lines[$i];
			}

			return \implode("\n", $lines);
		});

		$s = $s->replaceRegex('/!([^\n\s]+)!/', '![]($1)');
		$s = $s->replaceRegex('/\[([^|]+)\|(.+?)\]/', '[$1]($2)');
		$s = $s->replaceRegex('/\[(.+?)\]([^\(]+)/', '<$1>$2');

		$s = $s->replaceRegex('/{noformat}/', '```');
		$s = $s->replaceRegex('/{color:([^}]+)}([^]*?){color}/m', '<span style="color:$1">$2</span>');

		// Convert header rows of tables by splitting input on lines
		$lines = $s->splitRegex('/\r?\n/m');
		$lines_to_remove = [];
		$l = count($lines);
		for($i = 0; $i < $l; $i++) {
			$line_content = $lines[$i];

			$seperators = $line_content->matchAllRegex('/\|\|/');
			if($seperators !== null) {
				$lines[$i] = $lines[$i]->replaceRegex('/\|\|/', "|");

				// Add a new line to mark the header in Markdown,
				// we require that at least 3 -'s are between each |
				$header_line = \str_repeat('|---', count($seperators) -1) . "|";
				\array_splice($lines, $i + 1, 0, $header_line);
			}
		}

		return \implode("\n", $lines);
	}
}

