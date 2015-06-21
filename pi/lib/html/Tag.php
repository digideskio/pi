<?php

namespace Pi\Lib\Html;

class Tag {
  protected static $inlineTags = [
    'br',
    'hr',
    'img',
    'input'
  ];
  
  protected $name;
  protected $attrs;
  protected $content;

  public function __construct($name, $attrs = [], $content = '') {
    $this->name    = $name;
    $this->attrs   = $attrs;
    $this->content = $content;
  }

  public function addAttr($key, $value = true) {
    $this->attrs[$key] = $value;
  }

  public function addAttrs($attrs) {
    foreach ($attrs as $key => $value)
      $this->addAttr($key, $value);
  }

  public function removeAttr($key) {
    if (isset($this->attrs[$key])) {
      unset($this->attrs[$key]);
      return true;
    }

    return false;
  }

  public function removeAttrs($attrs) {
    foreach ($attrs as $key => $value)
      $this->removeAttr($key);
  }

  public function setContent($content) {
    $this->content = $content;
  }

  public function __toString() {
    $html = '<' . $this->name;

    foreach ($this->attrs as $key => $value)
      if (is_bool($value) && $value)
        $html .= ' ' . $key;
      else
        $html .= ' ' . $key . '="' . $value . '"';

    if (in_array($this->name, static::$inlineTags))
      $html .= ' />';
    else
      $html .= '>' . $this->content . '</' . $this->name . '>';

    return $html;
  }
}
