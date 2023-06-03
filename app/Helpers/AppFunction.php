<?php

function booleanConvert ($value)
{
    if (is_null($value)) {
        return null;
    } else if ($value == 0) {
        return false;
    } else if($value == 1) {
        return true;
    }
}