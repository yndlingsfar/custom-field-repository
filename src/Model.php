<?php

namespace Core\Models;

/**
 * Class Model
 * @package Core\Models
 */
class Model {


    const STATUS_PUBLISHED = 'publish';
    const STATUS_WAITING_SIS = 'private';
    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_TRASH = 'trash';

	/**
	 * @param $selector
	 * @param $postId
	 *
	 * @return mixed|null|void
	 */
	public static function get($selector, $postId) {
		return get_field($selector, $postId);
	}

	/**
	 * @param $selector
	 * @param $postId
	 *
	 * @return int|mixed|null|void
	 */
	public static function getTime($selector, $postId) {
		$time = self::get($selector, $postId);


		if (!$time instanceof \DateTime) {
			$dtmConverted = \DateTime::createFromFormat('d.m.Y', $time);
		} else {
			$dtmConverted = $time;
		}

		if ($dtmConverted) {
			return $dtmConverted->getTimestamp();
		}

		return $time;
	}

	/**
	 * @param $title
	 * @param $postType
	 * @param string $status
	 *
	 * @return int|\WP_Error
	 */
	public static function addPost($title, $postType, $status = self::STATUS_PUBLISHED ) {
		$post = array(
			'post_title'     => $title,
			'post_status'    => $status,
			'post_type'      => $postType
		);

		$postObject = get_page_by_title($title, null, $postType);
		if ($postObject instanceof \WP_Post) {
			wp_update_post( $postObject );
			return $postObject->ID;
		}

		return wp_insert_post($post);
	}

	/**
	 * @param $key
	 * @param $value
	 * @param $postId
	 */
	public static function update($key, $value, $postId) {
		update_field( $key, $value, $postId );
	}
}