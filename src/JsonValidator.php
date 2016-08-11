<?php

class JsonValidator
{
    public function validate($array_base, $array_data) {

        $diff = array_diff_key($array_base, $array_data);

        if(!$diff) {

            foreach($array_base as $key=>$item) {
                $isValid = true;

                if($item === 'int') {
                    if(!is_integer($array_data[$key])) {
                        $isValid = false;
                    }
                }

                if($item === 'bool') {
                    if(!is_bool($array_data[$key])){
                        $isValid = false;
                    }
                }

                if($item === 'string') {
                    if(!is_string($array_data[$key])) {
                        $isValid = false;
                    }
                }

                if($item === 'date') {
                    if(!\DateTime::createFromFormat('Y-m-d\TH:i:sP', $array_data[$key])) {
                        if (!$array_data[$key] instanceof DateTime) {
                            $isValid = false;
                        }
                    }
                }

                if(is_array($array_base[$key])) {
                    $this->validate($array_base[$key], $array_data[$key]);
                }

                if(!$isValid) {
                    throw new \Exception("Wrong Format");
                }
            }
        }

        if($diff) {
            throw new \Exception("The two arrays are different");
        }

        return true;
    }
}
