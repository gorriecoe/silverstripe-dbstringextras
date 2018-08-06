<?php

namespace gorriecoe\DBStringExtras;

use SilverStripe\Core\Convert;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\FieldType\DBHTMLText;

/**
 * Adds extra methods to strings
 *
 * @package silverstripe-dbstringextras
 */
class DBStringExtras extends DataExtension
{
    /**
     * Ensures that the methods are wrapped in the correct type and
     * values are safely escaped while rendering in the template.
     * @var array
     */
    private static $casting = [
        'Highlight' => 'HTMLFragment'
    ];

    /**
     * Replace all occurrences of the search string with the replacement string.
     * @return string
     */
    public function StrReplace($search = ' ', $replace = '')
    {
        $owner = $this->owner;
        $owner->value = str_replace(
            $search,
            $replace,
            $owner->value
        );
        return $owner;
    }

    /**
     * Converts this camel case and hyphenated string to a space separated string.
     * @return string
     */
    public function Nice()
    {
        $owner = $this->owner;
        $value = preg_replace('/([a-z)([A-Z0-9]])/', '$1 $2', $owner->value);
        $value = preg_replace('/([a-zA-Z])-([a-zA-Z0-9])/', '$1 $2', $value);
        $value = str_replace('_', ' ', $value);
        $owner->value = trim($value);
        return $owner;
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
        $owner = $this->owner;
        $owner->value = str_replace(
            [' ', '&nbsp'],
            '',
            $owner->value
        );
        return $owner;
    }

    /**
     * Converts square brackets [] within this string to a spans with css class.
     * @param string Define custom class
     * @return DBHTMLText
     */
    public function Highlight($class = 'highlight')
    {
        $owner = $this->owner;
        $new = DBHTMLText::create();
        $new->name = $owner->name;
        $owner->value = $owner->forTemplate();
        $new->value = preg_replace('/\[([^\]]*)\]/', '<span class="' . $class . '">$1</span>', $owner->value);
        return $new;
    }

    /**
     * Separates this string by lines into an ArrayList.
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
                ArrayData::create(['Line' => $line])
            );
        }
        return $lines;
    }

    /**
     * Separates this string by the specified delimiter.
     * Example template usage
     * ```
     * <% loop Content.Explode(',') %>
     *     <li>
     *         {$Value}
     *     </li>
     * <% end_loop %>
     * ```
     * @return ArrayList|Null
     */
    public function Explode($delimiter)
    {
        if (!$delimiter || !$string = $this->owner->value) {
            return;
        }
        $values = ArrayList::create();
        foreach (explode($delimiter, $string) as $value) {
            $values->push(
                ArrayData::create(['Value' => $value])
            );
        }
        return $values;
    }
}
