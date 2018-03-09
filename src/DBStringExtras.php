<?php

namespace gorriecoe\DBStringExtras;

use SilverStripe\Core\Convert;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\DataExtension;

/**
 * Adds extra methods to strings
 *
 * @package silverstripe-dbstringextras
 */
class DBStringExtras extends DataExtension
{
    /**
     * Replace all occurrences of the search string with the replacement string.
     * @return string
     */
    public function StrReplace($search = ' ', $replace = '')
    {
        return str_replace($search,$replace, $this->owner->value);
    }

    /**
     * Converts this camel case and hyphenated string to a space separated string.
     * @return string
     */
    public function Nice()
    {
        $value = preg_replace('/([a-z0-9])([A-Z])/', '$1 $2', $this->owner->value);
        $value = preg_replace('/([a-zA-Z])-([a-zA-Z])/', '$1 $2', $value);
        $value = str_replace('_', ' ', $value);
        $value = trim($value);
        return $value;
    }

    /**
     * Converts this camel case string to a hyphenated, kebab or spinal case string.
     */
    public function Hyphenate()
    {
        $value = preg_replace('/([A-Z])/', '-$1', $this->owner->value);
        $value = trim($value);
        return Convert::raw2url($value);
    }

    /**
     * Removes spaces from this string.
     * @return string
     */
    public function RemoveSpaces()
    {
        return str_replace(array(' ','&nbsp'), '', $this->owner->value);
    }

    /**
     * Converts square brackets [] within this string to a span with css class.
     * @param string Define custom class
     * @return string
     */
    public function Highlight($class = 'highlight')
    {
        return preg_replace('/\[([\w\d\s]*)\]/', '<span class="' . $class . '">$1</span>', $this->owner->value);
    }

    /**
     * Separates this string by lines into multiple an ArrayList.
     * Example template usage
     * ```
     * <% loop Content.SplitLines %>
     *     <div>
     *         {$Line}
     *     </div>
     * <% end_loop %>
     * ```
     * @return ArrayList|Null
     */
    public function SplitLines()
    {
        if (!$value = $this->owner->value) {
            return;
        }
        $lines = ArrayList::create();
        foreach (preg_split("/\n|<br\/?>/", $value) as $line) {
            $lines->push(
                ArrayData::create(
                    array(
                        'Line' => $line
                    )
                )
            );
        }
        return $lines;
    }
}
