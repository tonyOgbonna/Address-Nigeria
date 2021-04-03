<?php

namespace Drupal\address_nigeria\EventSubscriber;

use Drupal\address\Event\AddressEvents;
use Drupal\address\Event\AddressFormatEvent;
use Drupal\address\Event\SubdivisionsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Adds a predefined list of Local Govt admin area for Nigeria states.
 *
 * These Nigeria-specific state subdivisions are not provided by the
 * Address module by default.
 */
class AddressNigeriaEventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[AddressEvents::ADDRESS_FORMAT][] = ['onAddressFormat'];
    $events[AddressEvents::SUBDIVISIONS][] = ['onSubdivisions'];
    return $events;
  }

  /**
   * Alters the address format for Nigera.
   *
   * @param \Drupal\address\Event\AddressFormatEvent $event
   *   The address format event.
   */
  public function onAddressFormat(AddressFormatEvent $event) {
    $definition = $event->getDefinition();
    if ($definition['country_code'] == 'NG') {
      $definition['subdivision_depth'] = 2;
      $event->setDefinition($definition);
    }
  }

  /**
   * Provides the subdivisions for Nigeria states.
   *
   * @param \Drupal\address\Event\SubdivisionsEvent $event
   *   The subdivisions event.
   */
  public function onSubdivisions(SubdivisionsEvent $event) {
    $parents = $event->getParents();
    if ($event->getParents() == ['NG']) {
      $definitions = [
        'country_code' => $parents[0],
        'parents' => $parents,
        'subdivisions' => $this->getStates(),
      ];
    }
    elseif ($parents[1]) {
      $definitions = [
        'country_code' => $parents[0],
        'parents' => $parents,
        'subdivisions' => $this->getLgaSubdivisions($parents[1]),
      ];
    }
    else {
      return;
    }

    $event->setDefinitions($definitions);
  }

  /**
   * Provides states data formatted to enable further subdivisions.
   */
  public function getStates() {
    return [
      'AB' => [
        'name' => 'Abia',
        'has_children' => TRUE,
      ],
      'AD' => [
        'name' => 'Adamawa',
        'has_children' => TRUE,
      ],
      'AK' => [
        'name' => 'Akwa Ibom',
        'has_children' => TRUE,
      ],
      'AN' => [
        'name' => 'Anambra',
        'has_children' => TRUE,
      ],
      'BA' => [
        'name' => 'Bauchi',
        'has_children' => TRUE,
      ],
      'BY' => [
        'name' => 'Bayelsa',
        'has_children' => TRUE,
      ],
      'BE' => [
        'name' => 'Benue',
        'has_children' => TRUE,
      ],
      'BO' => [
        'name' => 'Borno',
        'has_children' => TRUE,
      ],
      'CR' => [
        'name' => 'Cross River',
        'has_children' => TRUE,
      ],
      'DE' => [
        'name' => 'Delta',
        'has_children' => TRUE,
      ],
      'EB' => [
        'name' => 'Ebonyi',
        'has_children' => TRUE,
      ],
      'ED' => [
        'name' => 'Edo',
        'has_children' => TRUE,
      ],
      'EK' => [
        'name' => 'Ekiti',
        'has_children' => TRUE,
      ],
      'EN' => [
        'name' => 'Enugu',
        'has_children' => TRUE,
      ],
      'GO' => [
        'name' => 'Gombe',
        'has_children' => TRUE,
      ],
      'IM' => [
        'name' => 'Imo',
        'has_children' => TRUE,
      ],
      'JI' => [
        'name' => 'Jigawa',
        'has_children' => TRUE,
      ],
      'KD' => [
        'name' => 'Kaduna',
        'has_children' => TRUE,
      ],
      'KN' => [
        'name' => 'Kano',
        'has_children' => TRUE,
      ],
      'KT' => [
        'name' => 'Katsina',
        'has_children' => TRUE,
      ],
      'KE' => [
        'name' => 'Kebbi',
        'has_children' => TRUE,
      ],
      'KO' => [
        'name' => 'Kogi',
        'has_children' => TRUE,
      ],
      'KW' => [
        'name' => 'Kwara',
        'has_children' => TRUE,
      ],
      'LA' => [
        'name' => 'Lagos',
        'has_children' => TRUE,
      ],
      'NA' => [
        'name' => 'Nasarawa',
        'has_children' => TRUE,
      ],
      'NI' => [
        'name' => 'Niger',
        'has_children' => TRUE,
      ],
      'OG' => [
        'name' => 'Ogun',
        'has_children' => TRUE,
      ],
      'ON' => [
        'name' => 'Ondo',
        'has_children' => TRUE,
      ],
      'OS' => [
        'name' => 'Osun',
        'has_children' => TRUE,
      ],
      'OY' => [
        'name' => 'Oyo',
        'has_children' => TRUE,
      ],
      'PL' => [
        'name' => 'Plateau',
        'has_children' => TRUE,
      ],
      'RI' => [
        'name' => 'Rivers',
        'has_children' => TRUE,
      ],
      'SO' => [
        'name' => 'Sokoto',
        'has_children' => TRUE,
      ],
      'TA' => [
        'name' => 'Taraba',
        'has_children' => TRUE,
      ],
      'YO' => [
        'name' => 'Yobe',
        'has_children' => TRUE,
      ],
      'ZA' => [
        'name' => 'Zamfara',
        'has_children' => TRUE,
      ],
      'FC' => [
        'name' => 'Federal Capital Territory (FCT)',
        'has_children' => TRUE,
      ],
    ];
  }

  /**
   * Returns Local Govt. list for each Nigeria state.
   *
   * @param string $state
   *   The state code.
   */
  public function getLgaSubdivisions($state) {
    $lgas = '';
    switch ($state) {
      case 'AB':
        $lgas = [
          'Aba North' => [],
          'Aba South' => [],
          'Arochukwu' => [],
          'Bende' => [],
          'Ikwuano' => [],
          'Isiala Ngwa North' => [],
          'Isiala Ngwa South' => [],
          'Isuikwuato' => [],
          'Obi Ngwa' => [],
          'Ohafia' => [],
          'Osisioma Ngwa' => [],
          'Ugwunagbo' => [],
          'Ukwa East' => [],
          'Ukwa West' => [],
          'Umuahia North' => [],
          'Umuahia South' => [],
          'Umu Nneochi' => [],
        ];

        break;

      case 'AD':
        $lgas = [
          'Demsa' => [],
          'Fufore' => [],
          'Ganye' => [],
          'Girei' => [],
          'Gombi' => [],
          'Guyuk' => [],
          'Hong' => [],
          'Jada' => [],
          'Lamurde' => [],
          'Madagali' => [],
          'Maiha' => [],
          'Mayo-Belwa' => [],
          'Michika' => [],
          'Mubi North' => [],
          'Mubi South' => [],
          'Numan' => [],
          'Shelleng' => [],
          'Song' => [],
          'Toungo' => [],
          'Yola North (State capital)' => [],
          'Yola South' => [],
        ];

        break;

      case 'AK':
        $lgas = [
          'Abak' => [],
          'Eastern Obolo' => [],
          'Eket' => [],
          'Esit-Eket' => [],
          'Essien Udim' => [],
          'Etim-Ekpo' => [],
          'Etinan' => [],
          'Ibeno[11]' => [],
          'Ibesikpo-Asutan' => [],
          'Ibiono-Ibom' => [],
          'Ika' => [],
          'Ikono' => [],
          'Ikot Abasi' => [],
          'Ikot Ekpene' => [],
          'Ini' => [],
          'Itu' => [],
          'Mbo' => [],
          'Mkpat-Enin' => [],
          'Nsit-Atai' => [],
          'Nsit-Ibom' => [],
          'Nsit-Ubium' => [],
          'Obot-Akara' => [],
          'Okobo' => [],
          'Onna' => [],
          'Oron' => [],
          'Oruk Anam' => [],
          'Ukanafun' => [],
          'Udung-Uko' => [],
          'Uruan' => [],
          'Urue-Offong/Oruko' => [],
          'Uyo' => [],
        ];

        break;

      case 'AN':
        $lgas = [
          'Aguata' => [],
          'Awka North' => [],
          'Awka South' => [],
          'Anambra East' => [],
          'Anambra West' => [],
          'Anaocha' => [],
          'Ayamelum' => [],
          'Dunukofia' => [],
          'Ekwusigo' => [],
          'Idemili North' => [],
          'Idemili South' => [],
          'Ihiala' => [],
          'Njikoka' => [],
          'Nnewi North' => [],
          'Nnewi South' => [],
          'Ogbaru' => [],
          'Onitsha North' => [],
          'Onitsha South' => [],
          'Orumba North' => [],
          'Orumba South' => [],
          'Oyi' => [],
        ];

        break;

      case 'BA':
        $lgas = [
          'Bauchi' => [],
          'Tafawa Balewa' => [],
          'Dass' => [],
          'Toro' => [],
          'Bogoro' => [],
          'Ningi' => [],
          'Warji' => [],
          'Ganjuwa' => [],
          'Kirfi' => [],
          'Alkaleri' => [],
          'Darazo' => [],
          'Misau' => [],
          'Giade' => [],
          'Shira' => [],
          'Jama are' => [],
          'Katagum' => [],
          'Itas/Gadau' => [],
          'Zaki' => [],
          'Gamawa' => [],
          'Damban' => [],
        ];

        break;

      case 'BY':
        $lgas = [
          'Brass' => [],
          'Ekeremor' => [],
          'Kolokuma/Opokuma' => [],
          'Nembe' => [],
          'Ogbia' => [],
          'Sagbama' => [],
          'Southern Ijaw' => [],
          'Yenagoa' => [],
        ];

        break;

      case 'BE':
        $lgas = [
          'Ado' => [],
          'Agatu' => [],
          'Apa' => [],
          'Buruku' => [],
          'Gboko' => [],
          'Guma' => [],
          'Gwer East' => [],
          'Gwer West' => [],
          'Katsina-Ala' => [],
          'Konshisha' => [],
          'Kwande' => [],
          'Logo' => [],
          'Makurdi' => [],
          'Obi' => [],
          'Ogbadibo' => [],
          'Ohimini' => [],
          'Oju' => [],
          'Okpokwu' => [],
          'Otukpo' => [],
          'Tarka' => [],
          'Ukum' => [],
          'Ushongo' => [],
          'Vandeikya' => [],
        ];

        break;

      case 'BO':
        $lgas = [
          'Abadam' => [],
          'Askira/Uba' => [],
          'Bama' => [],
          'Bayo' => [],
          'Biu' => [],
          'Chibok' => [],
          'Damboa' => [],
          'Dikwa' => [],
          'Gubio' => [],
          'Guzamala' => [],
          'Gwoza' => [],
          'Hawul' => [],
          'Jere' => [],
          'Kaga' => [],
          'Kala/Balge' => [],
          'Konduga' => [],
          'Kukawa' => [],
          'Kwaya Kusar' => [],
          'Mafa' => [],
          'Magumeri' => [],
          'Maiduguri' => [],
          'Marte' => [],
          'Mobbar' => [],
          'Monguno' => [],
          'Ngala' => [],
          'Nganzai' => [],
          'Shani' => [],
        ];

        break;

      case 'CR':
        $lgas = [
          'Abi' => [],
          'Akamkpa' => [],
          'Akpabuyo' => [],
          'Bekwarra' => [],
          'Bakassi' => [],
          'Biase' => [],
          'Boki' => [],
          'Calabar Municipal' => [],
          'Calabar South' => [],
          'Etung' => [],
          'Ikom' => [],
          'Obanliku' => [],
          'Obubra' => [],
          'Obudu' => [],
          'Odukpani' => [],
          'Ogoja' => [],
          'Yakuur' => [],
          'Yala' => [],
        ];

        break;

      case 'DE':
        $lgas = [
          'Aniocha North' => [],
          'Aniocha South' => [],
          'Bomadi' => [],
          'Burutu' => [],
          'Ethiope East' => [],
          'Ethiope West' => [],
          'Ika North East' => [],
          'Ika South' => [],
          'Isoko North' => [],
          'Isoko South' => [],
          'Ndokwa East' => [],
          'Ndokwa West' => [],
          'Okpe' => [],
          'Oshimili North' => [],
          'Oshimili South' => [],
          'Patani	67,391' => [],
          'Sapele' => [],
          'Udu' => [],
          'Ughelli North' => [],
          'Ughelli South' => [],
          'Ukwuani' => [],
          'Uvwie' => [],
          'Warri North' => [],
          'Warri South' => [],
          'Warri South West' => [],
        ];

        break;

      case 'EB':
        $lgas = [
          'Abakaliki' => [],
          'Afikpo North' => [],
          'Afikpo South (Edda)' => [],
          'Ebonyi' => [],
          'Ezza North' => [],
          'Ezza South' => [],
          'Ikwo' => [],
          'Ishielu' => [],
          'Ivo' => [],
          'Izzi' => [],
          'Ohaozara' => [],
          'Ohaukwu' => [],
          'Onicha' => [],
        ];

        break;

      case 'ED':
        $lgas = [
          'Akoko-Edo' => [],
          'Egor' => [],
          'Esan Central' => [],
          'Esan North-East' => [],
          'Esan South-East' => [],
          'Esan West' => [],
          'Etsako Central' => [],
          'Etsako East' => [],
          'Etsako West' => [],
          'Igueben' => [],
          'Ikpoba-Okha' => [],
          'Oredo' => [],
          'Orhionmwon' => [],
          'Ovia North-East' => [],
          'Ovia South-West' => [],
          'Owan East' => [],
          'Owan West' => [],
          'Uhunmwonde' => [],
        ];

        break;

      case 'EK':
        $lgas = [
          'Ado-Ekiti' => [],
          'Ikere' => [],
          'Oye' => [],
          'Aiyekire (Gbonyin)' => [],
          'Efon' => [],
          'Ekiti East' => [],
          'Ekiti South-West' => [],
          'Ekiti West' => [],
          'Emure' => [],
          'Ido-Osi' => [],
          'Ijero' => [],
          'Ikole' => [],
          'Ilejemeje' => [],
          'Irepodun/Ifelodun' => [],
          'Ise/Orun' => [],
          'Moba' => [],
        ];

        break;

      case 'EN':
        $lgas = [
          'Aninri' => [],
          'Awgu' => [],
          'Enugu East' => [],
          'Enugu North' => [],
          'Enugu South' => [],
          'Ezeagu' => [],
          'Igbo Etiti' => [],
          'Igbo Eze North' => [],
          'Igbo Eze South' => [],
          'Isi Uzo' => [],
          'Nkanu East' => [],
          'Nkanu West' => [],
          'Nsukka' => [],
          'Oji River' => [],
          'Udenu' => [],
          'Udi' => [],
          'Uzo-Uwani' => [],
        ];

        break;

      case 'GO':
        $lgas = [
          'Akko' => [],
          'Balanga' => [],
          'Billiri' => [],
          'Dukku' => [],
          'Funakaye' => [],
          'Gombe' => [],
          'Kaltungo' => [],
          'Kwami' => [],
          'Nafada' => [],
          'Shongom' => [],
          'Yamaltu/Deba' => [],
        ];

        break;

      case 'IM':
        $lgas = [
          'Aboh Mbaise' => [],
          'Ahiazu Mbaise' => [],
          'Ehime Mbano' => [],
          'Ezinihitte Mbaise' => [],
          'Ideato North' => [],
          'Ideato South' => [],
          'Ihitte/Uboma' => [],
          'Ikeduru' => [],
          'Isiala Mbano' => [],
          'Isu' => [],
          'Mbaitoli' => [],
          'Ngor Okpala' => [],
          'Njaba' => [],
          'Nkwerre' => [],
          'Nwangele' => [],
          'Obowo' => [],
          'Oguta' => [],
          'Ohaji/Egbema' => [],
          'Okigwe' => [],
          'Onuimo' => [],
          'Orlu' => [],
          'Orsu' => [],
          'Oru East' => [],
          'Oru West' => [],
          'Owerri Municipal' => [],
          'Owerri North' => [],
          'Owerri West' => [],
        ];

        break;

      case 'JI':
        $lgas = [
          'Auyo' => [],
          'Babura' => [],
          'Biriniwa' => [],
          'Birnin Kudu' => [],
          'Buji' => [],
          'Dutse' => [],
          'Gagarawa' => [],
          'Garki' => [],
          'Gumel' => [],
          'Guri' => [],
          'Gwaram' => [],
          'Gwiwa' => [],
          'Hadejia' => [],
          'Jahun' => [],
          'Kafin Hausa' => [],
          'Kaugama' => [],
          'Kazaure' => [],
          'Kiri Kasama' => [],
          'Kiyawa' => [],
          'Maigatari' => [],
          'Malam Madori' => [],
          'Miga' => [],
          'Ringim' => [],
          'Roni' => [],
          'Sule Tankarkar' => [],
          'Taura' => [],
          'Yankwashi' => [],
        ];

        break;

      case 'KD':
        $lgas = [
          'Birnin Gwari' => [],
          'Chikun' => [],
          'Giwa' => [],
          'Igabi' => [],
          'Ikara' => [],
          'Jaba' => [],
          'Jema\'a' => [],
          'Kachia' => [],
          'Kaduna North' => [],
          'Kaduna South' => [],
          'Kagarko' => [],
          'Kajuru' => [],
          'Kaura' => [],
          'Kauru' => [],
          'Kubau' => [],
          'Kudan' => [],
          'Lere' => [],
          'Makarf' => [],
          'Sabon Gari' => [],
          'Sanga' => [],
          'Soba' => [],
          'Zangon Kataf' => [],
          'Zaria' => [],
        ];

        break;

      case 'KN':
        $lgas = [
          'Fagge' => [],
          'Dala' => [],
          'Gwale' => [],
          'Kano Municipal' => [],
          'Tarauni' => [],
          'Nassarawa' => [],
          'Kumbotso' => [],
          'Ungogo' => [],
          'Dawakin Tofa' => [],
          'Tofa' => [],
          'Rimin Gado' => [],
          'Bagwai' => [],
          'Gezawa' => [],
          'Gabasawa' => [],
          'Minjibir' => [],
          'Dambatta' => [],
          'Makoda' => [],
          'Kunchi' => [],
          'Bichi' => [],
          'Tsanyawa' => [],
          'Shanono' => [],
          'Gwarzo' => [],
          'Karaye' => [],
          'Rogo' => [],
          'Kabo' => [],
          'Bunkure' => [],
          'Kibiya' => [],
          'Rano' => [],
          'Tudun Wada' => [],
          'Doguwa' => [],
          'Madobi' => [],
          'Kura' => [],
          'Garun Mallam' => [],
          'Bebeji' => [],
          'Kiru' => [],
          'Sumaila' => [],
          'Garko' => [],
          'Takai' => [],
          'Albasu' => [],
          'Gaya' => [],
          'Ajingi' => [],
          'Wudil' => [],
          'Warawa' => [],
          'Dawakin Kudu' => [],
        ];

        break;

      case 'KT':
        $lgas = [
          'Bakori' => [],
          'Batagarawa' => [],
          'Batsari' => [],
          'Baure' => [],
          'Bindawa' => [],
          'Charanchi' => [],
          'Dan Musa' => [],
          'Dandume' => [],
          'Danja' => [],
          'Daura' => [],
          'Dutsi' => [],
          'Dutsin-Ma' => [],
          'Faskari' => [],
          'Funtua' => [],
          'Ingawa' => [],
          'Jibia' => [],
          'Kafur' => [],
          'Kaita' => [],
          'Kankara' => [],
          'Kankia' => [],
          'Katsina' => [],
          'Kurfi' => [],
          'Kusada' => [],
          'Mai\'Adua' => [],
          'Malumfashi' => [],
          'Mani' => [],
          'Mashi' => [],
          'Matazu' => [],
          'Musawa' => [],
          'Rimi' => [],
          'Sabuwa' => [],
          'Safana' => [],
          'Sandamu' => [],
          'Zango' => [],
        ];

        break;

      case 'KE':
        $lgas = [
          'Aleiro' => [],
          'Arewa Dandi' => [],
          'Argungu' => [],
          'Augie' => [],
          'Bagudo' => [],
          'Birnin Kebbi' => [],
          'Bunza' => [],
          'Dandi' => [],
          'Fakai' => [],
          'Gwandu' => [],
          'Jega' => [],
          'Kalgo' => [],
          'Koko/Besse' => [],
          'Maiyama' => [],
          'Ngaski' => [],
          'Sakaba' => [],
          'Shanga' => [],
          'Suru' => [],
          'Wasagu' => [],
          'Yauri' => [],
          'Zuru' => [],
        ];

        break;

      case 'KO':
        $lgas = [
          'Adavi' => [],
          'Ajaokuta' => [],
          'Ankpa' => [],
          'Bassa' => [],
          'Dekina' => [],
          'Ibaji' => [],
          'Idah' => [],
          'Igalamela-Odolu' => [],
          'Ijumu' => [],
          'Kabba/Bunu' => [],
          'Koton Karfe' => [],
          'Lokoja' => [],
          'Mopa-Muro' => [],
          'Ofu' => [],
          'Ogori/Magongo' => [],
          'Okehi' => [],
          'Okene' => [],
          'Olamaboro' => [],
          'Omala' => [],
          'Yagba East' => [],
          'Yagba West' => [],
        ];

        break;

      case 'KW':
        $lgas = [
          'Asa' => [],
          'Baruten' => [],
          'Edu' => [],
          'Ekiti' => [],
          'Ifelodun' => [],
          'Ilorin East' => [],
          'Ilorin South' => [],
          'Ilorin West' => [],
          'Irepodun' => [],
          'Isin' => [],
          'Kaiama' => [],
          'Moro' => [],
          'Offa' => [],
          'Oke Ero' => [],
          'Oyun' => [],
          'Pategi' => [],
        ];

        break;

      case 'LA':
        $lgas = [
          'Agege' => [],
          'Ajeromi-Ifelodun' => [],
          'Alimosho' => [],
          'Amuwo-Odofin' => [],
          'Apapa' => [],
          'Badagry' => [],
          'Epe' => [],
          'Eti-Osa' => [],
          'Ibeju-Lekki' => [],
          'Ifako-Ijaye' => [],
          'Ikeja' => [],
          'Ikorodu' => [],
          'Kosofe' => [],
          'Lagos Island' => [],
          'Lagos Mainland' => [],
          'Mushin' => [],
          'Ojo' => [],
          'Oshodi-Isolo' => [],
          'Shomolu' => [],
          'Surulere' => [],
        ];

        break;

      case 'NA':
        $lgas = [
          'Karu' => [],
          'Keffi' => [],
          'Kokona' => [],
          'Nasarawa' => [],
          'Toto' => [],
          'Akwanga' => [],
          'Eggon' => [],
          'Wamba' => [],
          'Awe' => [],
          'Doma' => [],
          'Keana' => [],
          'Lafia' => [],
          'Obi' => [],
        ];

        break;

      case 'NI':
        $lgas = [
          'Agaie' => [],
          'Agwara' => [],
          'Bida' => [],
          'Borgu' => [],
          'Bosso' => [],
          'Chanchaga' => [],
          'Edati' => [],
          'Gbako' => [],
          'Gurara' => [],
          'Katcha' => [],
          'Kontagora' => [],
          'Lapai' => [],
          'Lavun' => [],
          'Magama' => [],
          'Mariga' => [],
          'Mashegu' => [],
          'Mokwa' => [],
          'Munya' => [],
          'Paikoro' => [],
          'Rafi' => [],
          'Rijau' => [],
          'Shiroro' => [],
          'Suleja' => [],
          'Tafa' => [],
          'Wushishi' => [],
        ];

        break;

      case 'OG':
        $lgas = [
          'Abeokuta North' => [],
          'Abeokuta South' => [],
          'Ado-Odo/Ota' => [],
          'Ewekoro' => [],
          'Ifo' => [],
          'Ijebu East' => [],
          'Ijebu North' => [],
          'Ijebu North East' => [],
          'Ijebu Ode' => [],
          'Ikenne' => [],
          'Imeko Afon' => [],
          'Ipokia' => [],
          'Obafemi Owode' => [],
          'Odogbolu' => [],
          'Odeda' => [],
          'Ogun Waterside' => [],
          'Remo North' => [],
          'Sagamu' => [],
          '(Shagamu)' => [],
          'Yewa North' => [],
          'Yewa South' => [],
        ];

        break;

      case 'ON':
        $lgas = [
          'Akoko North-East' => [],
          'Akoko North-West' => [],
          'Akoko South-East' => [],
          'Akoko South-West' => [],
          'Akure North' => [],
          'Akure South' => [],
          'Ese Odo' => [],
          'Idanre' => [],
          'Ifedore' => [],
          'Ilaje' => [],
          'Ile Oluji/Okeigbo' => [],
          'Irele' => [],
          'Odigbo' => [],
          'Okitipupa' => [],
          'Ondo East' => [],
          'Ondo West' => [],
          'Ose' => [],
          'Owo' => [],
        ];

        break;

      case 'OS':
        $lgas = [
          'Aiyedaade' => [],
          'Aiyedire' => [],
          'Atakunmosa East' => [],
          'Atakunmosa West' => [],
          'Boluwaduro' => [],
          'Boripe' => [],
          'Ede North' => [],
          'Ede South' => [],
          'Egbedore' => [],
          'Ejigbo' => [],
          'Ife Central' => [],
          'Ife East' => [],
          'Ife North' => [],
          'Ife South' => [],
          'Ifedayo' => [],
          'Ifelodun' => [],
          'Ila' => [],
          'Ilesa East' => [],
          'Ilesa West' => [],
          'Irepodun' => [],
          'Irewole' => [],
          'Isokan' => [],
          'Iwo' => [],
          'Obokun' => [],
          'Odo Otin' => [],
          'Ola Oluwa' => [],
          'Olorunda' => [],
          'Oriade' => [],
          'Orolu' => [],
          'Osogbo' => [],
        ];

        break;

      case 'OY':
        $lgas = [
          'Afijio' => [],
          'Akinyele' => [],
          'Atiba' => [],
          'Atisbo' => [],
          'Egbeda' => [],
          'Ibadan North' => [],
          'Ibadan North-East' => [],
          'Ibadan North-West' => [],
          'Ibadan South-East' => [],
          'Ibadan South-West' => [],
          'Ibarapa Central' => [],
          'Ibarapa East' => [],
          'Ibarapa North' => [],
          'Ido' => [],
          'Irepo' => [],
          'Iseyin' => [],
          'Itesiwaju' => [],
          'Iwajowa' => [],
          'Kajola' => [],
          'Lagelu' => [],
          'Ogbomosho North' => [],
          'Ogbomosho South' => [],
          'Ogo Oluwa' => [],
          'Olorunsogo' => [],
          'Oluyole' => [],
          'Ona Ara' => [],
          'Orelope' => [],
          'Ori Ire' => [],
          'Oyo East' => [],
          'Oyo West' => [],
          'Saki East' => [],
          'Saki West' => [],
          'Surulere' => [],
        ];

        break;

      case 'PL':
        $lgas = [
          'Barkin Ladi' => [],
          'Bassa' => [],
          'Bokkos' => [],
          'Jos East' => [],
          'Jos North' => [],
          'Jos South' => [],
          'Kanam' => [],
          'Kanke' => [],
          'Langtang North' => [],
          'Langtang South' => [],
          'Mangu' => [],
          'Mikang' => [],
          'Pankshin' => [],
          'Qua\'an Pan' => [],
          'Riyom' => [],
          'Shendam' => [],
          'Wase' => [],
        ];

        break;

      case 'RI':
        $lgas = [
          'Port Harcourt' => [],
          'Obio-Akpor' => [],
          'Okrika' => [],
          'Ogu–Bolo' => [],
          'Eleme' => [],
          'Tai' => [],
          'Gokana' => [],
          'Khana' => [],
          'Oyigbo' => [],
          'Opobo–Nkoro' => [],
          'Andoni' => [],
          'Bonny' => [],
          'Degema' => [],
          'Asari-Toru' => [],
          'Akuku-Toru' => [],
          'Abua–Odual' => [],
          'Ahoada West' => [],
          'Ahoada East' => [],
          'Ogba–Egbema–Ndoni' => [],
          'Emohua' => [],
          'Ikwerre' => [],
          'Etche' => [],
          'Omuma' => [],
        ];

        break;

      case 'SO':
        $lgas = [
          'Binji' => [],
          'Bodinga' => [],
          'Dange Shuni' => [],
          'Gada' => [],
          'Goronyo' => [],
          'Gudu' => [],
          'Gwadabawa' => [],
          'Illela' => [],
          'Isa' => [],
          'Kebbe' => [],
          'Kware' => [],
          'Rabah' => [],
          'Sabon Birni' => [],
          'Shagari' => [],
          'Silame' => [],
          'Sokoto North' => [],
          'Sokoto South' => [],
          'Tambuwal' => [],
          'Tangaza' => [],
          'Tureta' => [],
          'Wamako' => [],
          'Wurno' => [],
          'Yabo' => [],
        ];

        break;

      case 'TA':
        $lgas = [
          'Ardo Kola' => [],
          'Bali' => [],
          'Donga' => [],
          'Gashaka' => [],
          'Gassol' => [],
          'Ibi' => [],
          'Jalingo' => [],
          'Karim Lamido' => [],
          'Kurmi' => [],
          'Lau' => [],
          'Sardauna' => [],
          'Takum' => [],
          'Ussa' => [],
          'Wukari' => [],
          'Yorro' => [],
          'Zing' => [],
        ];

        break;

      case 'YO':
        $lgas = [
          'Bade' => [],
          'Bursari' => [],
          'Damaturu' => [],
          'Geidam' => [],
          'Gujba' => [],
          'Gulani' => [],
          'Fika' => [],
          'Fune' => [],
          'Jakusko' => [],
          'Karasuwa' => [],
          'Machina' => [],
          'Nangere' => [],
          'Nguru' => [],
          'Potiskum' => [],
          'Tarmuwa' => [],
          'Yunusari' => [],
          'Yusufari' => [],
        ];

        break;

      case 'ZA':
        $lgas = [
          'Anka' => [],
          'Bakura' => [],
          'Birnin Magaji/Kiyaw' => [],
          'Bukkuyum' => [],
          'Bungudu' => [],
          'Chafe (Tsafe)' => [],
          'Gummi' => [],
          'Gusau' => [],
          'Kaura Namoda' => [],
          'Maradun' => [],
          'Maru' => [],
          'Shinkafi' => [],
          'Talata Mafara' => [],
          'Zurmi' => [],
        ];

        break;

      case 'FC':
        $lgas = [
          'Abaji' => [],
          'Abuja' => [],
          'Bwari' => [],
          'Gwagwalada' => [],
          'Kuje' => [],
          'Kwali' => [],
        ];

        break;

      default:
        $lgas = [];
        break;
    }
    return $lgas;
  }

}
