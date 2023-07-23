<?php

namespace App\Enums;

enum MaterijalFields:string
{
    case FIELD_NAME ='name';
    case FIELD_SHORTNAME ='short_name';
    case FIELD_CONTACT_EMPLOYEE ='contact_employee';
    case FIELD_PIB ='pib';
    case FIELD_PHONE ='phone';
    case FIELD_WEB_SITE ='web_site';
    case FIELD_EMAIL ='email';
    case FIELD_SIFRA_DELATNOSTI ='sifra_delatnosti';
    case FIELD_ODGOVORNO_LICE ='odgovorno_lice';
    case FIELD_MATICNI_BROJ ='maticni_broj';
    case FIELD_MESTO ='mesto';
    case FIELD_ADDRESS ='address';
    case FIELD_ACTIVE ='active';
    case FIELD_INTERNAL_SIFRA ='internal_sifra';
    case FIELD_PRIPADA_PDVU ='pripada_pdvu';

}
