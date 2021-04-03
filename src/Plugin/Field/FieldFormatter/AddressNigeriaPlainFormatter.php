<?php

namespace Drupal\address_nigeria\Plugin\Field\FieldFormatter;

use Drupal\address\Plugin\Field\FieldFormatter\AddressPlainFormatter;
use Drupal\address\AddressInterface;
use Drupal\Core\Language\LanguageInterface;

/**
 * Plugin implementation of the 'address_nigeria_plain' formatter.
 *
 * @FieldFormatter(
 *   id = "address_nigeria_plain",
 *   label = @Translation("Plain (Nigeria)"),
 *   field_types = {
 *     "address",
 *   },
 * )
 */
class AddressNigeriaPlainFormatter extends AddressPlainFormatter {

  /**
   * Builds a renderable array for a single address item.
   *
   * @param \Drupal\address\AddressInterface $address
   *   The address.
   * @param string $langcode
   *   The language that should be used to render the field.
   *
   * @return array
   *   A renderable array.
   */
  protected function viewElement(AddressInterface $address, $langcode) {
    $country_code = $address->getCountryCode();
    $countries = $this->countryRepository->getList();
    $address_format = $this->addressFormatRepository->get($country_code);
    $values = $this->getValues($address, $address_format);
    $theme = 'address_plain';
    if ($country_code == 'NG') {
      $theme = 'address_nigeria_plain';
    }

    $element = [
      '#theme' => $theme,
      '#given_name' => $values['givenName'],
      '#additional_name' => $values['additionalName'],
      '#family_name' => $values['familyName'],
      '#organization' => $values['organization'],
      '#address_line1' => $values['addressLine1'],
      '#address_line2' => $values['addressLine2'],
      '#postal_code' => $values['postalCode'],
      '#sorting_code' => $values['sortingCode'],
      '#administrative_area' => $values['administrativeArea'],
      '#locality' => $values['locality'],
      '#dependent_locality' => $values['dependentLocality'],
      '#country' => [
        'code' => $country_code,
        'name' => $countries[$country_code],
      ],
      '#address' => $address,
      '#view_mode' => $this->viewMode,
      '#cache' => [
        'contexts' => [
          'languages:' . LanguageInterface::TYPE_INTERFACE,
        ],
      ],
    ];

    return $element;
  }

}
