<?php
/**
 * ZF1 example
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */

/**
 * Filter a string for url usage
 * 
 * Takes a string and filters it to be used for an url
 * 
 * @package    Library
 * @author     Ralf Eggert <r.eggert@travello.de>
 * @copyright  Copyright (c) 2013 Travello GmbH
 */
class Company_Filter_StringToUrl implements Zend_Filter_Interface
{
    /**
     * delimiter
     *
     * @var string
     */
    protected $_delimiter = null;

    /**
     * Sets the filter options
     *
     * @param  array|string $tagsAllowed
     * @param  array|string $attributesAllowed
     * @return void
     */
    public function __construct($delimiter = '-')
    {
        $this->_delimiter = $delimiter;
    }

    /**
     * Defined by Zend_Filter_Interface
     *
     * Returns the string $value, converting characters to be used in an URL as necessary
     *
     * @param  string $value
     * @return string
     */
    public function filter($value)
    {
        // build search array
        $search = array(
            '= |\(|\)|\/|\,|\'|´|\-|\_|`|\.|\@|\||&|\\\\=', // convert blank and special chars to "-"
            '=á|à|â|ã|ą|ă|ā|Â|Á|À|Ã|Ą|Ă|Ā=i',
            '=å|Å=i',
            '=ä|æ|Ä|Æ=i',
            '=ç|ć|č|ċ|ĉ|Ç|Ć|Č|Ċ|Ĉ=i',
            '=ď|Ď=i',
            '=ð|Ð=i',
            '=é|è|ê|ë|ę|ě|ē|ė|Ê|É|È|Ë|Ę|Ě|Ē|Ė=i',
            '=ğ|ġ|ĝ|ģ|Ğ|Ġ|Ĝ|Ģ=i',
            '=ħ|ĥ|Ħ|Ĥ=i',
            '=í|ì|î|ï|ı|ĩ|į|ï|Î|Í|Ì|Ï|İ|Ĩ|Į|Ī=i',
            '=ĵ|Ĵ=i',
            '=ķ|ĸ|Ķ=i',
            '=ł|ľ|ĺ|ļ|Ł|Ľ|Ĺ|Ļ=i',
            '=ñ|ń|ň|ņ|Ñ|Ń|Ň|Ņ=i',
            '=ó|ò|ô|õ|ő|ō|Ô|Ó|Ò|Õ|Ő|Ō=i',
            '=ö|ø|Ö|Ø=i',
            '=ŕ|ř|ŗ|Ŕ|Ř|Ŗ=i',
            '=š|ś|ş|ŝ|Š|Ś|Ş|Ŝ=i',
            '=ß=i',
            '=ť|ţ|ŧ|Ť|Ţ|Ŧ=i',
            '=Þ|þ=i',
            '=ú|ù|û|ů|ű|ŭ|ų|ũ|ū|Û|Ú|Ù|Ů|Ű|Ŭ|Ų|Ũ|Ū=i',
            '=ü|Ü=i',
            '=ý|ÿ|Ý|Ÿ=i',
            '=ź|ž|ż|Ź|Ž|Ż=i',
        );
        
        // build replace array
        $replace = array(
            $this->_delimiter,
            'a',
            'aa',
            'ae',
            'c',
            'd',
            'dj',
            'e',
            'g',
            'h',
            'i',
            'j',
            'k',
            'l',
            'n',
            'o',
            'oe',
            'r',
            's',
            'ss',
            't',
            'th',
            'u',
            'ue',
            'y',
            'z',
        );
        
        // replace special characters
        $value = preg_replace($search, $replace, (string) $value);
        
        // replace other characters
        $value = preg_replace('=[^a-z0-9' . $this->_delimiter . ']*=i', '', $value);
        
        // replace double -
        $value = preg_replace('=' . $this->_delimiter . '+=', $this->_delimiter, $value);
        
        // strip out leading and ending "-" 
        $value = preg_replace('=^' . $this->_delimiter . '|' . $this->_delimiter . '$=', '', $value);
        
        // convert to lower case
        return strtolower((string) $value);
    }
}
