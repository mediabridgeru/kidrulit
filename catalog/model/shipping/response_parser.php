<?php

interface response_parser
{
    public static function convert($data = '');
}

class parser_factoty
{
    private static $defaultType = 'xml';

    public static function convert($type, $data)
    {
        $class = 'parser_' . $type;

        if (!class_exists($class)) {
            $class = 'parser_' . self::$defaultType;
        }

        return $class::convert($data);
    }
}

class parser_json implements response_parser
{
    public static function convert($data = '')
    {
        return json_decode($data, TRUE);
    }
}

class parser_xml implements response_parser
{
    public static function convert($data = '')
    {
        $response = '';

        if (strpos($data, '<?xml') !== false) {

            libxml_use_internal_errors(true);

            try {
                $response = new SimpleXMLElement($data);
            } catch (Exception $e) {}
        }

        return $response;
    }
}
