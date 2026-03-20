<?php

declare (strict_types=1);
/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Open_Search_Dsl\Serializer\Normalizer;

use Open_Search_Dsl\Parameters_Trait;
/**
 * Custom abstract normalizer which can save references for other objects.
 */
abstract class Abstract_Normalizable
{
    use Parameters_Trait {
        Parameters_Trait::hasParameter as hasReference;
        Parameters_Trait::getParameter as getReference;
        Parameters_Trait::getParameters as getReferences;
        Parameters_Trait::addParameter as addReference;
        Parameters_Trait::removeParameter as removeReference;
        Parameters_Trait::setParameters as setReferences;
    }
}