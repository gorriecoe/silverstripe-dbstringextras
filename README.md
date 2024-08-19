# Silverstripe DBString Extras
Adds extra methods to Silverstripe DBStrings to help manipulate them.

## Installation
Composer is the recommended way of installing SilverStripe modules.
```
composer require gorriecoe/silverstripe-dbstringextras
```

## Requirements

- silverstripe/framework ^4 || ^5

## Maintainers

- [Gorrie Coe](https://github.com/gorriecoe)

## Documentation

### StrReplace

Replace all occurrences of the search string with the replacement string.

PHP
```php
$this->obj('MyString')->StrReplace('Search value', 'Replacement value')
```
Template
```
{$MyString.StrReplace('Search value', 'Replacement value')}
```
Input = Output
```
Ullamcorper Tellus Search value Egestas
=
Ullamcorper Tellus Replacement value Egestas
```

### Nice

Converts this camel case and hyphenated string to a space separated string.

PHP
```php
$this->obj('MyString')->Nice()
```
Template
```
{$MyString.Nice}
```
Input = Output
```
UllamCorper1tspHTML_-_Bibendum-egestas-1-1
=
Ullam Corper 1tsp HTML - Bibendum egestas 1-1
```

### Hyphenate

Converts this camel case string to a hyphenated, kebab or spinal case string.

PHP
```php
$this->obj('MyString')->Hyphenate()
```
Template
```
{$MyString.Hyphenate}
```
Input = Output
```
Ullamcorper Tellus Sollicitudin Bibendum Egestas
=
ullamcorper-tellus-sollicitudin-bibendum-egestas
```

### RemoveSpaces

Removes spaces from this string.

PHP
```php
$this->obj('MyString')->RemoveSpaces()
```
Template
```
{$MyString.RemoveSpaces}
```
Input = Output
```
Ullamcorper Tellus Sollicitudin Bibendum Egestas
=
UllamcorperTellusSollicitudinBibendumEgestas
```

### Highlight

Converts square brackets [] within this string to a spans with css class.

PHP
```php
$this->obj('MyString')->Highlight()
```
Template
```
{$MyString.Highlight}
or
{$MyString.Highlight('MyClass')}
```
Input = Output
```html
Ullamcorper [Tellus] Sollicitudin Bibendum Egestas
=
Ullamcorper <span class="highlight">Tellus</span> Sollicitudin Bibendum Egestas
```

### SplitLines

Separates this string by lines into an ArrayList.

Template
```
<% loop MyString.SplitLines %>
    <div>
        {$Line}
    </div>
<% end_loop %>
```
Input = Output
```html
Maecenas sed diam eget risus varius blandit sit amet non magna.
Etiam porta sem malesuada magna mollis euismod.
=
<div>
    Maecenas sed diam eget risus varius blandit sit amet non magna.
</div>
<div>
    Etiam porta sem malesuada magna mollis euismod.
</div>
```

### Explode

Separates this string by specified the delimiter.

Template
```
<% loop String.Explode(',') %>
    <li>
        {$Value}
    </li>
<% end_loop %>
```
Input = Output
```html
Aenean,Purus,Dolor,Magna
=
<li>Aenean</li>
<li>Purus</li>
<li>Dolor</li>
<li>Magna</li>
```
