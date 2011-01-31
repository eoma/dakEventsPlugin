<?php

require_once dirname(__FILE__).'/../lib/dakPictureAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dakPictureAdminGeneratorHelper.class.php';

/**
 * arranger actions.
 *
 * @package    kvarteret_events
 * @subpackage arranger
 * @author     Endre Oma
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dakPictureAdminActions extends autodakPictureAdminActions
{

  public function preExecute() {
    parent::preExecute();

    $this->configuration->setUser($this->getUser());
  }

  public function executeJsonSearch (sfWebRequest $request) {
    $term = trim($request->getParameter('term', ''));

    $description = '';
    if ($term != '') {
      $description = '%' . $term . '%';
    }

    $q = Doctrine_Core::getTable('dakPicture')->createQuery();
    PluginTagTable::getObjectTaggedWithQuery('dakPicture', $term, $q);

    $a = $q->getRootAlias();

    $where = $q->getDqlPart('where');
    if ($where[0] == 'false') { // No elements with the (possible) tags have been found


      $q->where($a .'.description LIKE ?', $description);
    } else {
      $a = $q->getRootAlias();
      $q->orWhere($a .'.description LIKE ?', $description);
    }

    $q->select( $a .'.id, '. $a .'.description, '. $a .'.height, '. $a .'.width');

    $q->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    $q->limit(20);

    $where = $q->getDqlPart('where');

    $result = $q->execute();

    if (count($result) > 0) {
      $picTags = array();
      foreach ($result as $p) { $picIds[] = $p['id']; }

      $qTags = Doctrine_Core::getTable('Tagging')->createQuery('tt');

      $qTags->leftJoin('tt.Tag t')
            ->select('tt.taggable_id, t.name, t.id')
            ->where('tt.taggable_model = ?', 'dakPicture')
            ->andWhereIn('tt.taggable_id', $picIds)
            ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);
      $tags = array();

      foreach ($qTags->execute() as $t) $tags[$t['taggable_id']][] = $t['Tag'];
    }

    $this->getContext()->getConfiguration()->loadHelpers('Url', 'UrlExtra', 'Image');

    $thumbRouteArgs = array(
      'type' => 'dakPicture',
      'format' => 'list'
    );

    foreach ($result as &$r) {
      $thumbRouteArgs['id'] = $r['id'];
      $r['thumbUrl'] = UrlExtraHelper::url_for_app('frontend', 'dak_thumb', $thumbRouteArgs);

      $thumbSizes = ImageHelper::TransformSize($thumbRouteArgs['format'], $r['width'], $r['height']);
      $r['thumbHeight'] = $thumbSizes['height'];
      $r['thumbWidth'] = $thumbSizes['width'];

      if (isset($tags[$r['id']])) {
        $r['Tags'] = $tags[$r['id']];
      } else {
        $r['Tags'] = array();
      }
    }

    return $this->returnJson($result);
  }

  public function returnJson($data) {
    $this->data = $data;

    if (sfConfig::get('sf_environment') == 'dev' && !$this->getRequest()->isXmlHttpRequest()) {
      $this->getResponse()->setHttpHeader('Content-type','text/plain');
      return $this->renderText(var_dump($data));
    } else {
      $this->getResponse()->setHttpHeader('Content-type','application/json');

      $string = '';

      if ( isset( $_GET['callback'] ) ) {
        $string = $_GET['callback'] . '(' . json_encode($data) . ')';
      } else {
        $string = json_encode($data);
      }
      return $this->renderText($string);
    }
  }

}
