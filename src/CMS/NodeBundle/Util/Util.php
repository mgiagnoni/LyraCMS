<?php

/*
 * This file is part of the CMSNodeBundle package.
 *
 * Copyright 2011 Massimo Giagnoni <gimassimo@gmail.com>
 *
 * This source file is subject to the MIT license. Full copyright and license
 * information are in the LICENSE file distributed with this source code.
 */

namespace CMS\NodeBundle\Util;

class Util
{
    static public function formatNode($value, $format, $object)
    {
        return str_repeat('- ', $object->getLevel()).$value;
    }
}
