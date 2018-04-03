<?php
declare(strict_types=1);

namespace Dojo\Builder;

use Exception;

class PostalAddress
{
    /** @var string */
    private $street;
    /** @var string */
    private $streetNumber;
    /** @var string */
    private $stairs;
    /** @var string */
    private $floor;
    /** @var string */
    private $door;
    /** @var string */
    private $postalCode;
    /** @var string */
    private $city;
    /** @var string */
    private $province;

    /**
     * PostalAddress constructor.
     * @param string $street
     * @param string $streetNumber
     * @param string $stairs
     * @param string $floor
     * @param string $door
     * @param string $postalCode
     * @param string $city
     * @param string $province
     */
    public function __construct(
        string $street,
        string $streetNumber,
        string $stairs,
        string $floor,
        string $door,
        string $postalCode,
        string $city,
        string $province
    ) {
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->stairs = $stairs;
        $this->floor = $floor;
        $this->door = $door;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->province = $province;
    }

    /**
     * @return string
     */
    public function street(): string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function streetNumber(): string
    {
        return $this->streetNumber;
    }

    /**
     * @return string
     */
    public function stairs(): string
    {
        return $this->stairs;
    }

    /**
     * @return string
     */
    public function floor(): string
    {
        return $this->floor;
    }

    /**
     * @return string
     */
    public function door(): string
    {
        return $this->door;
    }

    /**
     * @return string
     */
    public function postalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * @return string
     */
    public function city(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function province(): string
    {
        return $this->province;
    }

}

class PostalAddressBuilder
{
    /** @var string */
    private $street;
    /** @var string */
    private $streetNumber;
    /** @var string */
    private $stairs;
    /** @var string */
    private $floor;
    /** @var string */
    private $door;
    /** @var string */
    private $postalCode;
    /** @var string */
    private $city;
    /** @var string */
    private $province;
    /** @var PostalCodeService */
    private $postalCodeService;

    public function __construct(PostalCodeService $postalCodeService)
    {
        $this->street = '';
        $this->streetNumber = '';
        $this->stairs = '';
        $this->floor = '';
        $this->door = '';
        $this->postalCode = '';
        $this->city = '';
        $this->province = '';
        $this->postalCodeService = $postalCodeService;
    }

    public function build(): PostalAddress
    {
        try {
            return new PostalAddress(
                $this->street,
                $this->streetNumber,
                $this->stairs,
                $this->floor,
                $this->door,
                $this->postalCode,
                $this->city,
                $this->province
            );
        } catch (Exception $exception) {
            throw new InvalidArgumentException('It was impossible to create a PostalAddress', 1, $exception);
        }
    }

    public function withAddress(
        string $street,
        ?string $streetNumber,
        ?string $floor,
        ?string $door = null
    ): self {
        $this->street = $street;
        $this->streetNumber = $streetNumber;
        $this->floor = $floor;
        $this->door = $door;

        return $this;
    }

    public function atLocality(
        string $postalCode,
        string $city,
        string $province
    ): self {
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->province = $province;

        return $this;
    }

    public function at(string $city): self
    {
        try {
            $postalCodeRequest = new PostalCodeRequest($city, $this->street, $this->streetNumber);
            $response = $this->postalCodeService->find($postalCodeRequest);
            return $this->atLocality(
                $response->postalCode,
                $response->city,
                $response->province
            );
        } catch (Exception $exception) {
            throw new CityNotFoundException(sprintf('City %s could not be found', $city));
        }
    }
}
