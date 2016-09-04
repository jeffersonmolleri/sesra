<?php
// auto-generated by sfDefineEnvironmentConfigHandler
// date: 2014/05/19 09:42:25
sfConfig::add(array(
  'app_company_name' => 'SESRA',
  'app_company_title' => 'Software Engineering Systematic Review Automation',
  'app_levels_names' => array (
  0 => 'Coordenador',
  1 => 'Pesquisador',
  2 => 'Mediador/Revisor',
  3 => 'Interessado',
),
  'app_levels_ids' => array (
  'coordenador' => 0,
  'mediador' => 2,
),
  'app_solr_url_get_bagofword' => 'http://localhost:8983/solr/ars1/select/?',
  'app_solr_url_add' => 'http://localhost:8983/solr/ars1/update?commit=true',
  'app_solr_fields' => array (
  0 => 'comment',
  1 => 'preamble',
  2 => 'string',
  3 => 'entrytype',
  4 => 'address',
  5 => 'annote',
  6 => 'author',
  7 => 'booktitle',
  8 => 'crossref',
  9 => 'edition',
  10 => 'editor',
  11 => 'howpublished',
  12 => 'institution',
  13 => 'journal',
  14 => 'key',
  15 => 'month',
  16 => 'note',
  17 => 'number',
  18 => 'numpages',
  19 => 'organization',
  20 => 'pages',
  21 => 'publisher',
  22 => 'school',
  23 => 'series',
  24 => 'title',
  25 => 'type',
  26 => 'volume',
  27 => 'year',
  28 => 'abstract',
  29 => 'affiliation',
  30 => 'chaptername',
  31 => 'cited-by',
  32 => 'cites',
  33 => 'contents',
  34 => 'copyright',
  35 => 'date-added',
  36 => 'date-modified',
  37 => 'doi',
  38 => 'eprint',
  39 => 'isbn',
  40 => 'issn',
  41 => 'keywords',
  42 => 'language',
  43 => 'lccn',
  44 => 'lib-congress',
  45 => 'location',
  46 => 'price',
  47 => 'rating',
  48 => 'read',
  49 => 'size',
  50 => 'source',
  51 => 'url',
  52 => '_version_',
  53 => 'id',
),
  'app_invitations_sender' => 'jefferson@enova.com.br',
  'app_invitations_subject' => '[SESRA] Convite de pesquisa',
  'app_invitations_validationSubject' => '[SESRA] Validação de Protocolo',
  'app_invitations_timetableSubject' => '[SESRA] Atualização de cronograma',
  'app_invitations_tokenSubject' => '[SESRA] Nova chave de acesso',
  'app_etapa_url' => array (
  2 => 'systematic_review/needs?id=',
  3 => 'systematic_review/team?id=',
  5 => 'systematic_review/question?id=',
  6 => 'systematic_review/protocols?id=',
  7 => '@protocol_validation?id=',
  10 => '@studies_identification?id=',
  11 => '@studies_selection?id=',
  12 => '@studies_assessment?id=',
  13 => '@data_extraction?id=',
  14 => '@data_synthesis?id=',
  16 => 'systematic_review/dissemination?id=',
  17 => 'systematic_review/results?id=',
  18 => '@results_validation?id=',
),
  'app_bibtex_fields' => array (
  0 => 'address',
  1 => 'annote',
  2 => 'author',
  3 => 'booktitle',
  4 => 'chapter',
  5 => 'crossref',
  6 => 'edition',
  7 => 'editor',
  8 => 'howpublished',
  9 => 'institution',
  10 => 'journal',
  11 => 'key',
  12 => 'month',
  13 => 'note',
  14 => 'number',
  15 => 'organization',
  16 => 'pages',
  17 => 'publisher',
  18 => 'school',
  19 => 'series',
  20 => 'title',
  21 => 'type',
  22 => 'volume',
  23 => 'year',
),
));
