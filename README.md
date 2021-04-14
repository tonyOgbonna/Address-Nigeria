Address Nigeria
===============

Address Nigeria extends the Address module with the complete Nigeria-specific
Local Government subdivision data for all states and the Federal Capital
Territory (Abuja).

It also provides a Nigeria-specific Field Formatter and theme tempplate for
Nigeria addresses.

Installation
============
Install as a normal Drupal module.

Change the field formatter for the Address field you are using to
'Plain (Nigeria)'in the Manage Display setting of your target entity
type.

Further Helpful Setups
======================
The following are helpful module functions you could implement in a custom
module to fully customize the your address forms for Nigeria-specific
experience:

/**
 * Implements hook_form_alter().
 */
function address_nigeria_form_alter
(&$form, FormStateInterface $form_state, $form_id) {
  // kint($form);
  if (isset($form['field_address']['widget'][0]['address'])) {
    $form['field_address']['widget'][0]['address']
    ['#after_build'][] =
    'address_nigeria_customize_address';
  }
}

/**
 * address_nigeria_customize_address.
 */
function address_nigeria_customize_address($element, $form_state) {
  // skint($element);
  if ($element['country_code']['#value'] == 'NG') {
    $element['locality']['#title'] = t('Local Government Area');
  }

  return $element;
}
