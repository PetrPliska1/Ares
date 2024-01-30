<?php

namespace YourNamespace\Data;

readonly class EconomicallySubject {
    public function __construct(
        public string $ico,
        public string $businessName,
        public string $countryCode,
        public string $addressCity,
        public string $addressPostcode,
        public string $addressStreet,
        public string $legalForm,
    ) {
    }
}