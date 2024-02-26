<?php

namespace PWS\Billingo\Model\Config\Source;
use PWS\Billingo\lib\PWSBillingo;

class Entitlements implements \Magento\Framework\Option\ArrayInterface
{
    public static $entitlement_labels = [
        "AAM"           => "Alanyi adómentesség",
        "ANTIQUES"      => "Különbözet szerinti szabályozás - gyűjteménydarabok és régiségek",
        "ARTWORK"       => "Különbözet szerinti szabályozás - műalkotások",
        "ATK"           => "Áfa tv. tárgyi hatályán kívüli ügylet",
        "EAM"           => "Áfamentes termékexport, azzal egy tekintet alá eső értékesítések, nemzetközi közlekedéshez kapcsolódó áfamentes ügyletek (Áfa tv. 98-109. §)",
        "EUE"           => "EU más tagállamában áfaköteles (áfa fizetésére az értékesítő köteles)",
        "EUFAD37"       => "Áfa tv. 37. § (1) bekezdése alapján a szolgáltatás teljesítése helye az EU más tagállama (áfa fizetésére a vevő köteles)",
        "EUFADE"        => "Áfa tv. szerint egyéb rendelkezése szerint a teljesítés helye EU más tagállama (áfa fizetésére a vevő köteles)",
        "HO"            => "Áfa tv. szerint EU-n kívül teljesített ügylet",
        "KBAET"         => "Más tagállamba irányuló áfamentes termékértékesítés (Áfa tv. 89. §)",
        "NAM_1"         => "Áfamentes közvetítői tevékenység (Áfa tv. 110. §)",
        "NAM_2"         => "Termékek nemzetközi forgalmához kapcsolódó áfamentes ügylet (Áfa tv. 111-118. §)",
        "SECOND_HAND"   => "Különbözet szerinti szabályozás - használt cikkek",
        "TAM"           => "Tevékenység közérdekű jellegére vagy egyéb sajátos jellegére tekintettel áfamentes (Áfa tv. 85-87.§)",
        "TRAVEL_AGENCY" => "Különbözet szerinti szabályozás - utazási irodák"
    ];

    public function toOptionArray()
    {
        $entitlements = [];
        array_push($entitlements, ['value' => '', 'label' => __('---')]);
        foreach (PWSBillingo::ALL_ENTITLEMENTS as $entitlement) {
            array_push($entitlements, ['value' => $entitlement, 'label' => __(static::$entitlement_labels[$entitlement])]);
        }

        return $entitlements;
    }

    public function toArray()
    {
        $entitlements = [];
        $entitlements[''] = __('---');
        foreach (static::$entitlement_labels as $k => $v) {
            $entitlements[$k] = __($v);
        }

        return $entitlements;
    }
}
