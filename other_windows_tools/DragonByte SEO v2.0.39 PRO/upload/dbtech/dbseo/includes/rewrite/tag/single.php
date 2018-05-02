<?php if(!defined('IN_DBSEO')) die('Access denied.');

// #############################################################################
// DBSEO "Tag_Single URL" class

/**
* Lets you construct & lookup custom URLs
*/
class DBSEO_Rewrite_Tag_Single
{
	public static $format = 'Tags_Tag_Single';
	public static $structure = 'tags.php?tag=%s';

	/**
	 * Creates a SEO'd URL based on the URL fed
	 *
	 * @param string $url
	 * @param array $data
	 * 
	 * @return string
	 */
	public static function resolveUrl($urlInfo = array(), $structure = NULL)
	{
		if (DBSEO::$config['dbtech_dbseo_filter_blogtag'])
		{
			// Unfilter & encode blog tag
			$urlInfo['tag'] = urlencode(str_replace(array('&lt;', '&gt;', '&quot;', '&amp;'), array('<', '>', '"', '&'), DBSEO_Filter::reverseObject('tag', $urlInfo['tag'])));
		}
		
		return sprintf((is_null($structure) ? self::$structure : $structure), $urlInfo['tag'], $urlInfo['page']);
	}

	/**
	 * Creates a SEO'd URL based on the URL fed
	 *
	 * @param string $url
	 * @param array $data
	 * 
	 * @return string
	 */
	public static function createUrl($data = array(), $format = NULL)
	{
		if (!count(DBSEO::$cache['rawurls']))
		{
			// Ensure we got this kickstarted
			DBSEO::initUrlCache();
		}

		// Prepare the regexp format
		$format 		= explode('_', (is_null($format) ? self::$format : $format), 2);
		$rawFormat 		= DBSEO::$cache['rawurls'][strtolower($format[0])][$format[1]];

		// Init this
		$replace = array();

		if ($data['tag'])
		{
			// Sort out the tag
			$replace['%tag%'] = DBSEO_Filter::filterTag($data['tag']);
		}

		if ($data['page'])
		{
			// We had a paged blog
			$replace['%page%'] = $data['page'];
		}

		// Handle the replacements
		$newUrl = str_replace(array_keys($replace), $replace, $rawFormat);

		//if (strpos($newUrl, '%') !== false)
		//{
			// We should not return true if any single URL remains
			//return '';
		//}

		// Return the new URL
		return $newUrl;
	}
}