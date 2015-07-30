<?php

namespace Jules\Mvc;

class Tag
{
    // Title
    private $title = null;
    private $preTitle = null;

    // Select
    private $selectDefault = array();

    public function setTitle($string)
    {
        $this->title = $string;
    }

    public function prependTitle($string)
    {
        $this->preTitle = $string;
    }

    public function getTitle()
    {
        if(is_null($this->preTitle))
        {
            return '<title>'.$this->title.'</title>';
        }
        else
        {
            return '<title>'.$this->preTitle.$this->title.'</title>';
        }
    }

    public function image($src, $options = array('alt' => null, 'title' => null))
    {
        return '<img src="'.$src.'"'
            .(!is_null($options['alt']) ? ' alt="'.$options['alt'].'"' : '')
            .(!is_null($options['title']) ? ' title="'.$options['title'].'"' : '')
        .' />';
    }

    public function stylesheet($href)
    {
        return '<link rel="stylesheet" href="'.$href.'" type="text/css" />';
    }

    public function javascript($src)
    {
        return '<scrypt type="text/javascript" src="'.$src.'"></script>';
    }

    public function link($href, $anchor, $targetBlank = false)
    {
        return '<a href="'.$href.'"'.($targetBlank ? ' target="_blank"' : '').'>'.$anchor.'</a>';
    }

    public function textField($name, $options = array('maxlength' => null, 'placeholder' => null, 'size' => null))
    {
        return '<input type="text" name="'.$name.'" id="'.$name.'"'
            .(!is_null($options['maxlength']) ? ' maxlenght="'.$options['maxlength'].'"' : '')
            .(!is_null($options['placeholder']) ? ' placeholder="'.$options['placeholder'].'"' : '')
            .(!is_null($options['size']) ? ' size="'.$options['size'].'"' : '')
        .' />';
    }

    public function submitButton($value)
    {
        return '<input type="submit" value="'.$value.'" />';
    }

    public function form($action, $method = 'post')
    {
        return '<form action="'.$action.'" method="'.$method.'">';
    }

    public function endForm()
    {
        return '</form>';
    }

    public function textArea($name, $value = '', $options = array('cols' => null, 'rows' => null))
    {
        return '<textarea name="'.$name.'"'
            .(!is_null($options['cols']) ? ' cols="'.$options['cols'].'"' : '')
            .(!is_null($options['rows']) ? ' rows="'.$options['rows'].'"' : '')
        .'>'.$value.'</textarea>';
    }

    public function passwordField($name, $value = '')
    {
        return '<input type="password" name="'.$name.'" id="'.$name.'" value="'.$value.'" />';
    }

    public function hiddenField($name, $value = '')
    {
        return '<input type="hidden" name="'.$name.'" id="'.$name.'" value="'.$value.'" />';
    }

    public function selectDefault($name, $value)
    {
        $this->selectDefault[$name] = $value;
    }

    public function select($name, $value = array(), $options = array('useEmpty' => false, 'emptyText' => 'Choose...', 'emptyValue' => ''))
    {
        $selectedValue = (isset($this->selectDefault[$name]) ? $this->selectDefault[$name] : false);

        $select = '<select name="'.$name.'" id="'.$name.'">';

        if($options['useEmpty'])
        {
            $select .= '<option value="'.$options['emptyValue'].'"'.($selectedValue ? '' : ' selected="selected"').' disabled>'.$options['emptyText'].'</option>';
        }

        foreach($value as $key => $value)
        {
            if($value == $selectedValue)
            {
                $select .= '<option value="'.$key.'" selected="selected">'.$value.'</option>';
            }
            else
            {
                $select .= '<option value="'.$key.'">'.$value.'</option>';
            }
        }

        $select .= '</select>';

        return $select;
    }
}