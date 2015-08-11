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
            return '<title>'.$this->title.'</title>'.PHP_EOL;
        }
        else
        {
            return '<title>'.$this->preTitle.$this->title.'</title>'.PHP_EOL;
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
        global $Jules_url;
        $href = $Jules_url->buildUrl($href);
        return '<link rel="stylesheet" href="'.$href.'" type="text/css" />'.PHP_EOL;
    }

    public function javascript($src)
    {
        global $Jules_url;
        $src = $Jules_url->buildUrl($src);

        return '<script type="text/javascript" src="'.$src.'"></script>'.PHP_EOL;
    }

    public function link($href, $anchor, $options = array('class' => null, 'target' => null))
    {
        global $Jules_url;
        $href = $Jules_url->buildUrl($href);

        return '<a href="'.$href.'"'
            .(!is_null(@$options['class']) ? ' class="'.$options['class'].'"' : '')
            .(!is_null(@$options['target']) ? ' target="'.$options['target'].'"' : '')
        .'>'.$anchor.'</a>';
    }

    public function textField($name, $options = array('class' => null, 'maxlength' => null, 'placeholder' => null, 'size' => null))
    {
        return '<input type="text" name="'.$name.'" id="'.$name.'"'
            .(!is_null(@$options['class']) ? ' class="'.$options['class'].'"' : '')
            .(!is_null(@$options['maxlength']) ? ' maxlenght="'.$options['maxlength'].'"' : '')
            .(!is_null(@$options['placeholder']) ? ' placeholder="'.$options['placeholder'].'"' : '')
            .(!is_null(@$options['size']) ? ' size="'.$options['size'].'"' : '')
        .' />';
    }

    public function submitButton($value, $options = array('class' => null))
    {
        return '<input type="submit" value="'.$value.'"'
            .(!is_null(@$options['class']) ? ' class="'.$options['class'].'"' : '')
        . ' />';
    }

    public function form($action, $method = 'post')
    {
        global $Jules_url;
        $action = $Jules_url->buildUrl($action);

        return '<form action="'.$action.'" method="'.$method.'">';
    }

    public function endForm()
    {
        return '</form>';
    }

    public function textArea($name, $value = '', $options = array('cols' => null, 'rows' => null, 'style' => null, 'class' => null))
    {
        return '<textarea id="'.$name.'" name="'.$name.'"'
            .(!is_null(@$options['cols']) ? ' cols="'.$options['cols'].'"' : '')
            .(!is_null(@$options['rows']) ? ' rows="'.$options['rows'].'"' : '')
            .(!is_null(@$options['style']) ? ' style="'.$options['style'].'"' : '')
            .(!is_null(@$options['class']) ? ' class="'.$options['class'].'"' : '')
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

    private function buildSelectValues($data, $value, $text)
    {
        $response = array();

        foreach($data as $row)
        {
            $response[$row->getVar($value)] = $row->getVar($text);
        }

        return $response;
    }

    public function select($name, $data = array('data' => null, 'value' => null, 'text' => null), $options = array('useEmpty' => false, 'emptyText' => 'Choose...', 'emptyValue' => ''))
    {
        $selectedValue = (isset($this->selectDefault[$name]) ? $this->selectDefault[$name] : false);

        $select = '<select name="'.$name.'" id="'.$name.'">';

        if($options['useEmpty'])
        {
            $select .= '<option value="'.$options['emptyValue'].'"'.($selectedValue ? '' : ' selected="selected"').' disabled>'.$options['emptyText'].'</option>';
        }

        if(isset($data['data'][0]))
        {
            if(get_class($data['data'][0]) == 'Jules\Mvc\ModelObject')
            {
                $data = $this->buildSelectValues($data['data'], $data['value'], $data['text']);
            }
        }

        foreach($data as $key => $val)
        {
            if($key == $selectedValue)
            {
                $select .= '<option value="'.$key.'" selected="selected">'.$val.'</option>';
            }
            else
            {
                $select .= '<option value="'.$key.'">'.$val.'</option>';
            }
        }

        $select .= '</select>';

        return $select;
    }
}