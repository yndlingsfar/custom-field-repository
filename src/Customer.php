<?php

namespace Core\Models;
use Core\Query;

/**
 * Class Customer
 */
class Customer extends AbstractModel{

	/**
	 * @var string
	 */
	private $createTime;

	/**
	 * @var string
	 */
	private $updateTime;

	/**
	 * @var CustomerDetail
	 */
	private $customerDetail;

	/**
	 * @var array
	 */
	private $sisConfigs;

	/**
	 * @var ShopAdress
	 */
	private $shopAdress;

	const CREATE_TIME = 'field_55cd792d5da4f';
	const UPDATE_TIME = 'field_55cd79555da50';
	const REL_CUSTOMERS_DETAILS = 'field_55cd7c408b100';
	const REL_SHOP_ADRESS = 'field_55d175468a4ae';

	/**
	 * @return \DateTime
	 */
	public function getCreateTime() {
		return $this->get(self::CREATE_TIME, $this->createTime, true);
	}

	/**
	 * @param mixed $createTime
	 *
	 * @return $this
	 */
	public function setCreateTime( $createTime ) {
		$this->set(self::CREATE_TIME, $createTime, $this->createTime);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getUpdateTime() {
		return $this->get(self::UPDATE_TIME, $this->updateTime, true);

	}

	/**
	 * @param mixed $updateTime
	 *
	 * @return $this
	 */
	public function setUpdateTime( $updateTime ) {
		$this->set(self::UPDATE_TIME, $updateTime, $this->updateTime);

		return $this;
	}

	/**
	 * @return CustomerDetail
	 */
	public function getCustomerDetail() {

		if ($this->customerDetail instanceof CustomerDetail) {
			return $this->customerDetail;
		}
		$customerDetailId = $this->get(self::REL_CUSTOMERS_DETAILS, $this->customerDetail);
		$this->customerDetail = new CustomerDetail($customerDetailId[0]);

		return $this->customerDetail;
	}

	/**
	 * @param mixed $customerDetail
	 *
	 * @return $this
	 */
	public function setCustomerDetail( CustomerDetail $customerDetail ) {
		$this->customerDetail = $customerDetail;

		return $this;
	}

	/**
	 * @return ShopAdress
	 */
	public function getShopAdress() {

		if ($this->shopAdress instanceof ShopAdress) {
			return $this->shopAdress;
		}

		$shopAdressId = $this->get(self::REL_SHOP_ADRESS, $this->shopAdress);
		$this->shopAdress = new ShopAdress($shopAdressId[0]);

		return $this->shopAdress;
	}

	/**
	 * @return array|null
	 */
	public function getConfigurations() {
		$query = new Query();
		$sis = [];

		$all = $query->getSisConfigurationByCustomerId($this->id);

		if ($all) {
			/** @var SisConfiguration $configuration */
			foreach ($all as $configuration) {
				$sis[] = $query->getSisConfigurationAsArray($configuration);
			}
		}

		$this->sisConfigs = $sis;
	}

	/**
	 * @param ShopAdress $shopAdress
	 *
	 * @return $this
	 */
	public function setShopAdress( ShopAdress $shopAdress ) {
		$this->shopAdress = $shopAdress;

		return $this;
	}

	public function flush($status = Query::STATUS_PUBLISHED) {

		if ($this->customerDetail instanceof CustomerDetail) {
			$this->customerDetail->flush();
			$this->setReference(self::REL_CUSTOMERS_DETAILS, $this->customerDetail->id);
		}

		if ($this->shopAdress instanceof ShopAdress) {
			$this->shopAdress->flush();
			$this->setReference(self::REL_SHOP_ADRESS, $this->shopAdress->id);
		}

		parent::flush();

	}

	/**
	 * @return string
	 * @throws \Exception
	 */
	public function getTitle() {

		if ($this->id) {
			$page = get_post($this->id);
			return $page->post_title;
		}

		if ($this->customerDetail instanceof CustomerDetail && $this->customerDetail->getCustomerDescription()) {
			return $this->customerDetail->getCustomerNr() . ': ' . $this->customerDetail->getCustomerDescription();
		}

		throw new \Exception('Unable to identify the record. At least a CustomerDetail has to be set');
	}

	/**
	 * Checks if the post is currently on status hidden in database
	 *
	 * @return bool
	 */
	public function isHidden() {

		if (!$this->id) {
			return false;
		}

		return get_post_status($this->id) == Query::STATUS_HIDDEN;
	}

	/**
	 * @return string
	 */
	public function getName() {
		return Query::POST_TYPE_CUSTOMER;
	}
}