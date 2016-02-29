<?php

namespace Pi;

use IteratorAggregate;

use Pi\Lib\Str;

class PageCollection implements IteratorAggregate {
    private $pages;

    public function __construct($pages) {
        $this->pages = $pages;
    }

    /// Pages dont le slug commence par
    public function slugStartsWith($name) {
        $this->pages = array_filter($this->pages, function($page) use ($name) {
            return Str::startsWith($page, $name);
        });

        return $this;
    }

    /// Pages dont le slug finit par
    public function slugEndsWith($name) {
        $this->pages = array_filter($this->pages, function($page) use ($name) {
            return Str::endsWith($page, $name);
        });

        return $this;
    }

    /// Pages dont le slug contient
    public function slugContains($name) {
        $this->pages = array_filter($this->pages, function($page) use ($name) {
            return Str::contains($page, $name);
        });

        return $this;
    }

    /// à faire : Pages qui contiennent le champ
    public function containsField($name) {
        $this->pages = array_filter($this->pages, function($page) use ($name) {
            return true;
        });

        return $this;
    }

    /// à faire : Pages dont le champ vaut
    public function fieldValueIs($fieldName, $fieldValue) {
        $this->pages = array_filter($this->pages, function($page) use ($name) {
            return true;
        });

        return $this;
    }

    public function getIterator() {
        foreach ($this->pages as $page)
            yield $page;
    }

    public static function newWithAllPages() {
        $dirs = scandir('content/pages');

        $dirs = array_filter($dirs, function($dir) {
            return ($dir != '.' && $dir != '..');
        });

        $dirs = array_values($dirs);

        $self = new static($dirs);

        return $self;
    }
}
