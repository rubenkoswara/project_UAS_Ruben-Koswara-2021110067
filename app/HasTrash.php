<?php

namespace App;

trait HasTrash
{
    public static function trashQuery()
    {
        return static::onlyTrashed();
    }

}
