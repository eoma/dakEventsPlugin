<?php

class myHTMLPurifier extends HTMLPurifier {

	public function createConfig () {
		$config = HTMLPurifier_Config::createDefault();

		// cache dir, just for symfony of course, you can change to another path
		$config->set('Cache.SerializerPath', sfConfig::get('sf_cache_dir'));

		$config->set('HTML.Doctype', 'XHTML 1.0 Strict');

		$config->set('HTML.TidyLevel', 'heavy');

		return $config;
	}

	/**
	 * Will strip all html elements except a, strong, em, p, span, img, li, ul, ol and blockquote
	 */
	public function commonHtml ($value) {
		$config = $this->createConfig();

		// purifier configuration:
		// documentation: http://stackoverflow.com/questions/1320524/how-to-allow-certain-html-tags-in-a-form-field-in-symfony-1-2/1321794#1321794

		$config->set('HTML.DefinitionID', 'commonHtml');
		$config->set('HTML.DefinitionRev', 1);

		// clean empty tags
		$config->set('AutoFormat.RemoveEmpty', true);
		//$config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
		//$config->set('AutoFormat.RemoveEmpty.RemoveNbsp.Exceptions', array());

		// these are allowed html tags, means white list
		$config->set('HTML.AllowedElements', 'a,strong,em,p,span,img,li,ul,ol,blockquote');

		// these are allowed html attributes, coool!
		$config->set('HTML.AllowedAttributes', 'a.href,a.title,span.style,span.class,span.id,p.style,img.src,img.style,img.alt,img.title,img.width,img.height');

		return $this->purify($value, $config);
	}

	/**
	 * Will strip away all elements except p elements
	 */
	public function basicHtml ($value) {
		$config = $this->createConfig();

		$config->set('HTML.DefinitionID', 'basicHtml');
		$config->set('HTML.DefinitionRev', 1);

		// clean empty tags
		$config->set('AutoFormat.RemoveEmpty', true);
		$config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
		//$config->set('AutoFormat.RemoveEmpty.RemoveNbsp.Exceptions', array());

		// these are allowed html tags, means white list
		$config->set('HTML.AllowedElements', 'p');

		return $this->purify($value, $config);
	}

	/**
	 * Will strip away all htmltags
	 */
	public function noHtml ($value) {
		$config = $this->createConfig();

		$config->set('HTML.DefinitionID', 'noHtml');
		$config->set('HTML.DefinitionRev', 1);

		// clean empty tags
		$config->set('AutoFormat.RemoveEmpty', true);
		$config->set('AutoFormat.RemoveEmpty.RemoveNbsp', true);
		//$config->set('AutoFormat.RemoveEmpty.RemoveNbsp.Exceptions', array());

		// these are allowed html tags, means white list
		$config->set('HTML.AllowedElements', '');

		return $this->purify($value, $config);
	}
}
