<?php

use EphenyxShop\PhenyxXls\Shared\Date;
use \Curl\Curl;

/**
 * Class StudentEducationCore
 *
 * @since 2.1.0.0
 */
class StudentEducationCore extends PhenyxObjectModel {

	const ROUND_ITEM = 1;
	const ROUND_LINE = 2;
	const ROUND_TOTAL = 3;

	protected static $instance;

	public $_languages;
	// @codingStandardsIgnoreStart
	/**
	 * @see PhenyxObjectModel::$definition
	 */
	public static $definition = [
		'table'     => 'student_education',
		'primary'   => 'id_student_education',
		'multilang' => true,
		'fields'    => [
			'id_sale_agent'              => ['type' => self::TYPE_INT],
			'id_sale_agent_commission'   => ['type' => self::TYPE_INT],
			'id_organism'                => ['type' => self::TYPE_INT],
            'id_cart_education'          => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
			'commission_amount'          => ['type' => self::TYPE_FLOAT, 'validate' => 'isPrice'],
			'commission_due'             => ['type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false],
			'commission_paid'            => ['type' => self::TYPE_BOOL, 'validate' => 'isBool', 'copy_post' => false],
			'id_education_session'       => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
			'date_start'                 => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
			'date_end'                   => ['type' => self::TYPE_DATE, 'validate' => 'isDate'],
			'id_user'                    => ['type' => self::TYPE_INT, 'required' => true, 'validate' => 'isUnsignedId'],
			'id_product'                 => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
			'id_product_attribute'       => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
			'id_student_education_state' => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
			'id_education_supplies'      => ['type' => self::TYPE_INT],
			'supply_name'                => ['type' => self::TYPE_STRING, 'size' => 32],
			'id_formatpack'              => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
			'price'                      => ['type' => self::TYPE_FLOAT, 'validate' => 'isPrice'],
			'is_edof'                    => ['type' => self::TYPE_BOOL],
			'reference_organism'         => ['type' => self::TYPE_INT],
			'course_link'                => ['type' => self::TYPE_STRING, 'size' => 128],
            'identifiant'                => ['type' => self::TYPE_STRING, 'size' => 64],
			'passwd_link'                => ['type' => self::TYPE_STRING, 'size' => 64],
            'hours'                      => ['type' => self::TYPE_INT, 'validate' => 'isUnsignedId'],
			'first_connection'           => ['type' => self::TYPE_DATE, 'copy_post' => false],
			'notes'                      => ['type' => self::TYPE_STRING, 'size' => 128],
			'educLaunch'                 => ['type' => self::TYPE_BOOL],
			'isLaunch'                   => ['type' => self::TYPE_BOOL],
			'is_start'                   => ['type' => self::TYPE_BOOL],
			'doc_return'                 => ['type' => self::TYPE_BOOL],
			'shipping_number'            => ['type' => self::TYPE_STRING, 'validate' => 'isTrackingNumber', 'size' => 64],
			'shipping_sms'               => ['type' => self::TYPE_BOOL],
			'education_lenghts'          => ['type' => self::TYPE_NOTHING],
			'deleted'                    => ['type' => self::TYPE_BOOL],
			'eval_hot'                   => ['type' => self::TYPE_BOOL],
			'eval_cold'                  => ['type' => self::TYPE_BOOL],
			'attest_end'                 => ['type' => self::TYPE_BOOL],
			'id_certification'           => ['type' => self::TYPE_INT],
			'id_platform'                => ['type' => self::TYPE_INT],
			'is_invoice'                 => ['type' => self::TYPE_BOOL],
			'pass_certif'                => ['type' => self::TYPE_BOOL],
            'phone_mobile'               => ['type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber', 'size' => 32],
			'deleted_reason'             => ['type' => self::TYPE_STRING, 'size' => 256],
			'date_add'                   => ['type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDate'],
			'date_upd'                   => ['type' => self::TYPE_DATE, 'shop' => true, 'validate' => 'isDate'],

            'generated'                 => ['type' => self::TYPE_BOOL, 'lang' => true],
			'link_rewrite'               => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isLinkRewrite', 'size' => 128],
			'name'                       => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isCatalogName', 'required' => true, 'size' => 128],
		],
	];

	public $id_student_education;
    public $id_cart_education;
	public $id_sale_agent;
	public $id_organism;
	public $id_sale_agent_commission;
	public $commission_amount;

	public $commission_due = 0;
	public $commission_paid = 0;
	public $id_education_session;
	public $id_user;
	public $id_product;
	public $id_product_attribute;
	public $id_student_education_state;
	public $id_education_supplies;
	public $supply_name;
	public $id_formatpack;
	public $price;
	public $is_edof;
	public $reference_organism;
    public $course_link;
	public $identifiant;
	public $passwd_link;
	public $first_connection;
	public $notes;
	public $educLaunch;
	public $isLaunch;
	public $is_start;
	public $doc_return;
	public $shipping_number;
	public $shipping_sms;
	public $education_lenghts = '00:00:00';
	public $deleted;
	public $deleted_reason;
	public $eval_hot;
	public $eval_cold;
	public $attest_end;
	public $id_certification;
	public $id_platform;
	public $pass_certif;
	public $date_add;
	public $date_upd;
	public $state;
	public $reference;
    public $generated;
	public $name;
	public $link_rewrite;
	public $days;
	public $hours;
	public $educationType;
	public $rate;
	public $priceWTax;
	public $sessionName;
	public $date_start;
	public $date_contrat;
	public $date_limit;
	public $date_begin;
	public $date_final;
	public $supplyName;
	public $date_end;
	public $duration;
	public $ratio;
	public $agent;
	public $firstname;
	public $lastname;
	public $email;
	public $phone_mobile;
	public $session_date;
	public $certificationName;
	public $id_education_prerequis;
	public $educationPlatform;
	public $formaPack;
	public $score_hot;
	public $answer_hot;
	public $is_invoice = 0;
	public $tax_rate;
    public $certification;
    public $certifications;
	public $organism;
    public $reservation_link;

	/**
	 * CustomerCore constructor.
	 *
	 * @param int|null $id
	 *
	 * @since 2.1.0.0
	 * @throws PhenyxException
	 */
	public function __construct($id = null, $idLang = null, $full = false) {

        $this->is_archivable = true;
        $context = Context::getContext();
		if (is_null($idLang)) {
			$idLang = Context::getContext()->language->id;
		}

		parent::__construct($id, $idLang);

		$this->_languages = Language::getLanguages(false);

		if ($this->id) {         

			$this->id_student_education = $this->id;
			$this->state = $this->getState();
			$details = Product::getEducationDetails($this->id_product, $this->id_product_attribute, false);

			foreach ($details as $key => $value) {
				$this->$key = $value;
			}

			if (!is_null($this->id_certification) && $this->id_certification > 0 && $this->is_edof) {
				$this->reservation_link = $this->getReservationLink();
			}

			$this->priceWTax = round($this->price * (1 + $this->rate / 100), 2);
			$this->price = round($this->price, 2);
			$this->sessionName = $this->getSessionDateName();

			$this->date_begin = $this->getDateStart();
			$this->date_final = $this->getDateEnd();
			$date_start = $this->getDateStart();
			$date = new DateTime($this->date_start);
			$date->modify('+15 days');
			$this->date_contrat = $date->format('d/m/Y');
			$date = new DateTime($this->date_start);
			$date->modify('-14 days');
			$this->date_limit = $date->format('d/m/Y');

			if ($this->use_education_device) {
                if(empty($this->supply_name)) {
                    $this->supplyName = $this->getSupply();
                } else {
                    $this->supplyName = $this->supply_name;
                }
				
			}

			$this->duration = $this->getDuration();
			$this->ratio = $this->getRatio();

			if ($this->use_sale_agent) {
				$this->agent = $this->getAgent();
			}

			$this->firstname = $this->getStudentFirstnamme();
			$this->lastname = $this->getStudentLastnamme();
			$this->email = $this->getStudentEmail();
			$this->session_date = $this->date_start;
			$this->id_education_prerequis = $this->getIdPrerequis();
			$this->answer_hot = $this->isHotAnswer();
			$this->score_hot = $this->getHotScore();
            $this->certifications = $this->getCertification();
			$certification = new Certification($this->id_certification, $this->context->language->id);
			$this->certificationName = $certification->name;

			if ($this->id_organism > 0) {
				$this->organism = $this->getOrganisName();
			}
            if($full) {
               // $context->studentEducation = $this;
            }

		}

	}

	public static function getInstance() {

		if (!StudentEducation::$instance) {
			StudentEducation::$instance = new StudentEducation();
		}

		return StudentEducation::$instance;
	}

	public function getOrganisName() {

		$organism = new Organism($this->id_organism);
		return $organism->organism_name;
	}
    
    public function getReservationLink() {
        
        if($this->id_product_attribute > 0) {
            return Db::getInstance()->getValue(
                (new DbQuery())
                 ->select('`edof_link`')
                 ->from('education_link')
                 ->where('`id_product` = ' . $this->id_product)
                 ->where('`id_certification` = ' . $this->id_certification)
                 ->where('`id_product_attribute` = ' . $this->id_product_attribute)
            );
        } else {
            return Db::getInstance()->getValue(
                (new DbQuery())
                 ->select('`edof_link`')
                 ->from('education_link')
                 ->where('`id_product` = ' . $this->id_product)
                 ->where('`id_certification` = ' . $this->id_certification)
                 ->where('`id_product_attribute` = 0')
            );
        }
    }
    
    public function getCertification() {
        
        $certifications = [];
        
        $certifications = Db::getInstance()->getValue(
            (new DbQuery())
             ->select('`certifications`')
             ->from('product')
             ->where('`id_product` = ' . $this->id_product)
        );
        if(!empty($certifications)) {
            $certifications = Tools::jsonDecode($certifications, true);
        }
        
        return $certifications;
    }
    
    public function compileArchive() {
        
        
        $context = Context::getContext();
        
        $idRequest = ParagridRequest::getRequestIdBy('StudentEducation');

        if ($idRequest > 0) {
            $request = new ParagridRequest($idRequest, $context->language->id);
            
        } else {
            $request = new ParagridRequest();
            $request->class = 'StudentEducation';
        }
        $context = Context::getContext();
        $query = new DbQuery();
        $query->select('s.*, sl.name, c.firstname, c.lastname, c.birthname, c.email, c.password, gl.name as title, e.is_edof,  cer.name as certificationName,   sep.id_student_education_prerequis, o.`organism_name`,  a.phone, a.phone_mobile, a.postcode, a.city');
        if ($this->use_education_step) {
            $query->select('est.`name` as state');
        }
        if ($this->use_session) {
            $query->select('es.name as `dateSession`, es.session_date');
        }
        if ($this->use_education_platform) {
            $query->select('e.id_platform as educationPlatform');
        }
        if ($this->use_education_device) {
            $query->select('esu.name as supplyName');
        }
        $query->from('student_education', 's');
        $query->leftJoin('student_education_lang', 'sl', 'sl.`id_student_education` = s.`id_student_education` AND sl.id_lang = ' . $context->language->id);
        $query->leftJoin('certification_lang', 'cer', 'cer.`id_certification` = s.`id_certification` AND cer.id_lang = ' . $context->language->id);
        $query->leftJoin('organism', 'o', 'o.`id_organism` = s.`id_organism`');
        $query->leftJoin('user', 'c', 'c.`id_user` = s.`id_user`');
        $query->innerJoin('address', 'a', 'a.`id_user` = c.`id_user`');
        if ($this->use_education_step) {
            $query->leftJoin('student_education_state_lang', 'est', 'est.`id_student_education_state` = s.`id_student_education_state` AND est.`id_lang` = ' . $context->language->id);
        }
        if ($this->use_session) {
            $query->leftJoin('education_session', 'es', 'es.`id_education_session` = s.`id_education_session`');
        }
        $query->leftJoin('product', 'e', 'e.`id_product` = s.`id_product`');
        $query->leftJoin('gender_lang', 'gl', 'gl.`id_gender` = c.`id_gender` AND gl.`id_lang` = ' . $context->language->id);
        if ($this->use_education_device) {
            $query->leftJoin('education_supplies', 'esu', 'esu.`id_education_supplies` = s.`id_education_supplies` ');
        }
        $query->leftJoin('student_education_prerequis', 'sep', 'sep.`id_student_education` = s.`id_student_education` ');
        $query->where('s.deleted = 0');
        $query->where('s.is_invoice = 1');
        $query->orderBy('date_start DESC');

        $students = Db::getInstance(_EPH_USE_SQL_SLAVE_)->executeS($query);

        foreach ($students as &$student) {

            if ($student['pass_certif']) {
                $student['certif_state'] = '<div style="color:green"><i class="fa-duotone fa-check"></i></div>';
            } else {
                $student['certif_state'] = '<div style="color:red"><i class="fa-duotone fa-xmark"></i></div>';
            }

            $educations = Product::getEducationDetails($student['id_product'], $student['id_product_attribute'], false);

            foreach ($educations as $key => $value) {

                $student[$key] = $value;
            }

            $student['FinalPrice'] = $student['price'] * (1 + $student['rate'] / 100);

            if ($this->use_sale_agent) {
                $student['agent'] = '';

                if ($student['id_sale_agent'] > 0) {
                    $agent = SaleAgent::getSaleAgentbyId($student['id_sale_agent']);
                    $student['agent'] = $agent['firstname'] . ' ' . $agent['lastname'];
                }

            }

            if ($this->use_education_step) {

                if ($student['id_student_education_state'] > 6) {
                    $student['connexionLenght'] = (int) str_replace(":", "", $student['education_lenghts']) > 0 ? 1 : 0;
                    $time = strtotime($student['session_date']);

                    $lenght = explode(":", $student['education_lenghts']);
                    $time = Tools::convertTimetoHex($lenght[0], $lenght[1]);

                    if ($student['hours'] > 0) {
                        $student['ratio'] = round($time * 100 / $student['hours'], 2) . ' %';
                    } else {
                        $student['ratio'] = '0 %';
                    }

                } else {
                    $student['ratio'] = '0 %';
                }

            }

            if (!Validate::isUnsignedId($student['id_student_education_prerequis'])) {
                $student['id_student_education_prerequis'] = 0;
            }

        }

        
        $request->archive = Tools::jsonEncode($students, JSON_HEX_QUOT | JSON_HEX_TAG);

        if ($idRequest > 0) {
            $request->update();
        } else {
            $request->add();
        }
    }
    
    public function updateCompile() {

        $context = Context::getContext();
        $query = new DbQuery();
        $query->select('s.*, sl.name, c.firstname, c.lastname, c.birthname, c.email, c.password, gl.name as title, e.is_edof,  cer.name as certificationName,   sep.id_student_education_prerequis, o.`organism_name`,  a.phone, a.phone_mobile, a.postcode, a.city');
        if ($this->use_education_step) {
            $query->select('est.`name` as state');
        }
        if ($this->use_session) {
            $query->select('es.name as `dateSession`, es.session_date');
        }
        if ($this->use_education_platform) {
            $query->select('e.id_platform as educationPlatform');
        }
        if ($this->use_education_device) {
            $query->select('esu.name as supplyName');
        }
        $query->from('student_education', 's');
        $query->leftJoin('student_education_lang', 'sl', 'sl.`id_student_education` = s.`id_student_education` AND sl.id_lang = ' . $context->language->id);
        $query->leftJoin('certification_lang', 'cer', 'cer.`id_certification` = s.`id_certification` AND cer.id_lang = ' . $context->language->id);
        $query->leftJoin('organism', 'o', 'o.`id_organism` = s.`id_organism`');
        $query->leftJoin('user', 'c', 'c.`id_user` = s.`id_user`');
        $query->innerJoin('address', 'a', 'a.`id_user` = c.`id_user`');
        if ($this->use_education_step) {
            $query->leftJoin('student_education_state_lang', 'est', 'est.`id_student_education_state` = s.`id_student_education_state` AND est.`id_lang` = ' . $context->language->id);
        }
        if ($this->use_session) {
            $query->leftJoin('education_session', 'es', 'es.`id_education_session` = s.`id_education_session`');
        }
        $query->leftJoin('product', 'e', 'e.`id_product` = s.`id_product`');
        $query->leftJoin('gender_lang', 'gl', 'gl.`id_gender` = c.`id_gender` AND gl.`id_lang` = ' . $context->language->id);
        if ($this->use_education_device) {
            $query->leftJoin('education_supplies', 'esu', 'esu.`id_education_supplies` = s.`id_education_supplies` ');
        }
        $query->leftJoin('student_education_prerequis', 'sep', 'sep.`id_student_education` = s.`id_student_education` ');
        $query->where('s.deleted = 0');
        $query->orderBy('date_start DESC');
        $query->where('s.id_student_education = ' . (int) $this->id);
        
        $newEducation = Db::getInstance()->getRow($query);

		if ($newEducation['pass_certif']) {
			$newEducation['certif_state'] = '<div style="color:green"><i class="fa-duotone fa-check"></i></div>';
		} else {
			$newEducation['certif_state'] = '<div style="color:red"><i class="fa-duotone fa-xmark"></i></div>';
		}

		$educations = Product::getEducationDetails($newEducation['id_product'], $newEducation['id_product_attribute'], false);

		foreach ($educations as $key => $value) {
			$newEducation[$key] = $value;
		}

		$newEducation['FinalPrice'] = $newEducation['price'] * (1 + $newEducation['rate'] / 100);

		if ($this->use_sale_agent) {
			$newEducation['agent'] = '';

			if ($newEducation['id_sale_agent'] > 0) {
				$agent = SaleAgent::getSaleAgentbyId($newEducation['id_sale_agent']);
				$newEducation['agent'] = $agent['firstname'] . ' ' . $agent['lastname'];
			}

		}

		if ($newEducation['id_student_education_state'] > 6) {
			$newEducation['connexionLenght'] = (int) str_replace(":", "", $newEducation['education_lenghts']) > 0 ? 1 : 0;
			$time = strtotime($newEducation['date_start']);

			$lenght = explode(":", $newEducation['education_lenghts']);
			$time = Tools::convertTimetoHex($lenght[0], $lenght[1]);

			if ($newEducation['hours'] > 0) {
				$newEducation['ratio'] = round($time * 100 / $newEducation['hours'], 2) . ' %';
			} else {
				$newEducation['ratio'] = '0 %';
			}

		} else {
			$newEducation['ratio'] = '0 %';
		}

		if (!Validate::isUnsignedId($newEducation['id_student_education_prerequis'])) {
			$newEducation['id_student_education_prerequis'] = 0;
		}

        

        $idRequest = ParagridRequest::getRequestIdBy('StudentEducation');
        $request = new ParagridRequest($idRequest);
        $educations = $request->archive;

        array_unshift($educations, $newEducation);

        $request->archive = Tools::jsonEncode($educations, JSON_HEX_QUOT | JSON_HEX_TAG);
        $request->update();
    }


	public function add($autoDate = true, $nullValues = true) {

		foreach (Language::getIDs(false) as $idLang) {
			$this->name = [$idLang => $this->getEducationName($idLang)];
			$this->link_rewrite = [$idLang => Tools::str2url($this->name[$idLang])];
		}
        $this->phone_mobile = $this->getStudentPhoneMobile();
        $this->course_link = $this->getCourseLink();
        if(empty($this->supply_name)) {
            $this->supply_name = $this->getSupply();
        }

		$success = parent::add($autoDate, $nullValues);

		$refresh = Configuration::get('EPH_FULL_CACHE_MODE');

		if ($success) {
			$context = Context::getContext();

			$this->updateStudentlastEducation();

			if ($this->use_sale_agent && $this->id_sale_agent > 0) {
				$saleAgent = new SaleAgent($this->id_sale_agent);

				if ($saleAgent->sale_commission_amount == 0 || $saleAgent->employee_type == 'Salarié') {
					return $success;
				}

			}

		}

		if ($refresh) {
			$this->addArchive();
		}

		return $success;
	}

	public function update($nullValues = false, $reindex = true) {

		$context = Context::getContext();
		$idLang = $context->language->id;

		if ($this->use_session) {
			$session = new EducationSession($this->id_education_session);
		}

		$Education = new Product($this->id_product);
		$refresh = Configuration::get('EPH_FULL_CACHE_MODE');

		if ($Education->cache_default_attribute == 0) {
			$this->id_product_attribute = 0;
		}

		$oldStEducation = new StudentEducation($this->id);

		if (!$oldStEducation->pass_certif && $this->pass_certif) {
			$certification = new EducationCertification();
			$certification->id_student_education = $this->id;
			$certification->id_certification = $this->id_certification;
			$certification->add();
		}
        $is_invoice = true;
        if($oldStEducation->id_student_education_state < 9) {
            $is_invoice = false;
        }

		$this->name = [$idLang => $this->getEducationName($idLang)];
		$this->link_rewrite = [$idLang => Tools::str2url($this->name[$idLang])];

		if ($this->use_education_device && isset($context->employee) && $context->employee->master_admin == 0 && $session->sessionClosed && $oldStEducation->id_education_supplies != $this->id_education_supplies) {
			$return = [
				'success' => false,
				'message' => 'Cette session est clôturée, vous ne pouvez plus changer le matériel pédagogique. Veuillez contacter Stella',
			];
			die(Tools::jsonEncode($return));
		}

		if ($this->use_education_device && isset($context->employee) && $context->employee->master_admin == 0 && $session->sessionClosed && $oldStEducation->id_education_session != $this->id_education_session) {
			$return = [
				'success' => false,
				'message' => 'Cette session est clôturée, vous ne pouvez plus changer la date de session. Veuillez contacter Stella',
			];
			die(Tools::jsonEncode($return));
		}

		if ($this->use_sale_agent && $this->id_sale_agent > 0) {
			$saleAgent = new SaleAgent($this->id_sale_agent);

			if ($saleAgent->sale_commission_amount == 0 || $saleAgent->employee_type == 'Salarié') {
				$result = parent::update($nullValues);

				if ($refresh) {
					//$this->updateArchive();
				}

				return $result;

			}

			$this->commission_amount = $saleAgent->sale_commission_amount;

			if ($refresh) {
				//$saleAgent->updateArchive();
			}

		}

		$result = parent::update($nullValues);

		if ($refresh) {
		//	$this->updateArchive();
		}
        if(!$is_invoice && $reindex && $this->id_student_education_state == 9) {
          //  $this->updateCompile();
        }

		return $result;

	}

	public function delete() {

		$idCommission = 0;
		$refresh = Configuration::get('EPH_FULL_CACHE_MODE');

		Db::getInstance()->execute(
			(new DbQuery())
				->type('DELETE')
				->from('student_education_prerequis')
				->where('`id_student_education` = ' . (int) $this->id)
		);
		Db::getInstance()->execute(
			(new DbQuery())
				->type('DELETE')
				->from('student_education_suivie')
				->where('`id_student_education` = ' . (int) $this->id)
		);
		Db::getInstance()->execute(
			(new DbQuery())
				->type('DELETE')
				->from('student_evaluation')
				->where('`id_student_education` = ' . (int) $this->id)
		);
		Db::getInstance()->execute(
			(new DbQuery())
				->type('DELETE')
				->from('student_education_certification')
				->where('`id_student_education` = ' . (int) $this->id)
		);

		if ($refresh) {
			$this->removeArchive();
			$user = new User($this->id_user);
		}

		$success = parent::delete();

		if ($refresh) {
			$user->updateArchive();
		}

		return $success;
	}
    
    public function getCourseLink() {
        
        if($this->id_product_attribute > 0) {
            $course_link = Db::getInstance()->getValue('
                SELECT education_link
                FROM ' . _DB_PREFIX_ . 'product_attribute
                WHERE id_product_attribute = '.$this->id_product_attribute.' AND id_product='.$this->id_product
            );
        } else {
            $course_link = Db::getInstance()->getValue('
                SELECT education_link
                FROM ' . _DB_PREFIX_ . 'product
                WHERE id_product='.$this->id_product
            );
        }
        
        return $course_link;
    }

	public function getEducationName($idLang) {

		if ($this->id_product_attribute == 0) {

			return Db::getInstance(_EPH_USE_SQL_SLAVE_)->getValue(
				(new DbQuery())
					->select('name')
					->from('product_lang')
					->where('id_product = ' . $this->id_product)
					->where('id_lang = ' . $idLang)
			);

		} else {

			return Db::getInstance(_EPH_USE_SQL_SLAVE_)->getValue(
				(new DbQuery())
					->select('eal.name')
					->from('product_attribute', 'ea')
					->leftJoin('product_attribute_lang', 'eal', 'eal.id_product_attribute = ea.id_product_attribute')
					->where('ea.id_product_attribute = ' . (int) $this->id_product_attribute)
					->where('ea.id_product = ' . $this->id_product)
					->where('eal.id_lang = ' . $idLang)
			);
		}

	}

	public function getDescriptionShort($idLang) {

		if ($this->id_product_attribute == 0) {

			return Db::getInstance(_EPH_USE_SQL_SLAVE_)->getValue(
				(new DbQuery())
					->select('description_short')
					->from('product_lang')
					->where('id_product = ' . $this->id_product)
					->where('id_lang = ' . $idLang)
			);

		} else {

			return Db::getInstance(_EPH_USE_SQL_SLAVE_)->getValue(
				(new DbQuery())
					->select('eal.description_short')
					->from('product_attribute', 'ea')
					->leftJoin('product_attribute_lang', 'eal', 'eal.id_product_attribute = ea.id_product_attribute')
					->where('ea.id_product_attribute = ' . (int) $this->id_product_attribute)
					->where('ea.id_product = ' . $this->id_product)
					->where('eal.id_lang = ' . $idLang)
			);
		}

	}

	public function getRequest() {

		$context = Context::getContext();
		$idRequest = ParagridRequest::getRequestIdBy('StudentEducation');

		if ($idRequest > 0) {
			$request = new ParagridRequest($idRequest, $context->language->id);

			if (!empty($request->request) && is_array($request->request) && count($request->request)) {
				return $request->request;
			}

		}

		return self::archiveRequest();

	}

	public function updateArchive() {

		$context = Context::getContext();
		$query = new DbQuery();
		$query->select('s.*, sl.name, c.firstname, c.lastname, c.birthname, c.email, c.password, est.`name` as state, gl.name as title, cer.name as certificationName, sep.id_student_education_prerequis,  a.phone, a.phone_mobile, a.postcode, a.city');

		if ($this->use_session) {
			$query->select('es.name as `dateSession`, es.session_date');
		}

		if ($this->use_education_device) {
			$query->select('esu.name as supplyName');
		}

		if ($this->use_education_platform) {
			$query->select('e.id_platform as educationPlatform');
		}

		$query->from('student_education', 's');
		$query->leftJoin('student_education_lang', 'sl', 'sl.`id_student_education` = s.`id_student_education` AND sl.id_lang = ' . $context->language->id);
		$query->leftJoin('certification_lang', 'cer', 'cer.`id_certification` = s.`id_certification` AND cer.id_lang = ' . $context->language->id);
		$query->leftJoin('user', 'c', 'c.`id_user` = s.`id_user`');
		$query->innerJoin('address', 'a', 'a.`id_user` = c.`id_user`');
		$query->leftJoin('student_education_state_lang', 'est', 'est.`id_student_education_state` = s.`id_student_education_state` AND est.`id_lang` = ' . $context->language->id);

		if ($this->use_session) {
			$query->leftJoin('education_session', 'es', 'es.`id_education_session` = s.`id_education_session`');
		}

		$query->leftJoin('product', 'e', 'e.`id_product` = s.`id_product`');
		$query->leftJoin('gender_lang', 'gl', 'gl.`id_gender` = c.`id_gender` AND gl.`id_lang` = ' . $context->language->id);

		if ($this->use_education_device) {
			$query->leftJoin('education_supplies', 'esu', 'esu.`id_education_supplies` = s.`id_education_supplies` ');
		}

		$query->leftJoin('student_education_prerequis', 'sep', 'sep.`id_student_education` = s.`id_student_education` ');
		$query->where('s.deleted = 0');
		$query->where('s.id_student_education = ' . (int) $this->id);
		$newStudent = Db::getInstance()->getRow($query);

		if ($newStudent['pass_certif']) {
			$newStudent['certif_state'] = '<div style="color:green"><i class="fa-duotone fa-check"></i></div>';
		} else {
			$newStudent['certif_state'] = '<div style="color:red"><i class="fa-duotone fa-xmark"></i></div>';
		}

		$educations = Product::getEducationDetails($newStudent['id_product'], $newStudent['id_product_attribute'], false);

		foreach ($educations as $key => $value) {
			$newStudent[$key] = $value;
		}

		$newStudent['FinalPrice'] = $newStudent['price'] * (1 + $newStudent['rate'] / 100);

		if ($this->use_sale_agent) {
			$newStudent['agent'] = '';

			if ($newStudent['id_sale_agent'] > 0) {
				$agent = SaleAgent::getSaleAgentbyId($newStudent['id_sale_agent']);
				$newStudent['agent'] = $agent['firstname'] . ' ' . $agent['lastname'];
			}

		}

		if ($newStudent['id_student_education_state'] > 6) {
			$newStudent['connexionLenght'] = (int) str_replace(":", "", $newStudent['education_lenghts']) > 0 ? 1 : 0;
			$time = strtotime($newStudent['date_start']);

			$lenght = explode(":", $newStudent['education_lenghts']);
			$time = Tools::convertTimetoHex($lenght[0], $lenght[1]);

			if ($newStudent['hours'] > 0) {
				$newStudent['ratio'] = round($time * 100 / $newStudent['hours'], 2) . ' %';
			} else {
				$newStudent['ratio'] = '0 %';
			}

		} else {
			$newStudent['ratio'] = '0 %';
		}

		if (!Validate::isUnsignedId($newStudent['id_student_education_prerequis'])) {
			$newStudent['id_student_education_prerequis'] = 0;
		}

		$idRequest = ParagridRequest::getRequestIdBy('StudentEducation');
		$request = new ParagridRequest($idRequest, $context->language->id);
		$students = $request->request;

		foreach ($students as &$student) {

			if ($student['id_student_education'] == (int) $this->id) {

				foreach ($student as $key => $value) {

					if (array_key_exists($key, $newStudent)) {
						$student[$key] = $newStudent[$key];
					}

				}

				break;
			}

		}

		$request->request = Tools::jsonEncode($students, JSON_HEX_QUOT | JSON_HEX_TAG);
		$request->update();
	}

	public static function archiveRequest() {

		$context = Context::getContext();
		$idRequest = ParagridRequest::getRequestIdBy('StudentEducation');

		if ($idRequest > 0) {
			$request = new ParagridRequest($idRequest, $context->language->id);
		} else {
			$request = new ParagridRequest();
			$request->class = 'StudentEducation';
		}

		$query = new DbQuery();
		$query->select('s.*, sl.name, c.firstname, c.lastname, c.birthname, c.email, c.password, est.`name` as state, gl.name as title, cer.name as certificationName, sep.id_student_education_prerequis,  a.phone, a.phone_mobile, a.postcode, a.city');

		if ($this->use_session) {
			$query->select('es.name as `dateSession`, es.session_date');
		}

		if ($this->use_education_device) {
			$query->select('esu.name as supplyName');
		}

		if ($this->use_education_platform) {
			$query->select('e.id_platform as educationPlatform');
		}

		$query->from('student_education', 's');
		$query->leftJoin('student_education_lang', 'sl', 'sl.`id_student_education` = s.`id_student_education` AND sl.id_lang = ' . $context->language->id);
		$query->leftJoin('certification_lang', 'cer', 'cer.`id_certification` = s.`id_certification` AND cer.id_lang = ' . $context->language->id);
		$query->leftJoin('user', 'c', 'c.`id_user` = s.`id_user`');
		$query->innerJoin('address', 'a', 'a.`id_user` = c.`id_user`');
		$query->leftJoin('student_education_state_lang', 'est', 'est.`id_student_education_state` = s.`id_student_education_state` AND est.`id_lang` = ' . $context->language->id);

		if ($this->use_session) {
			$query->leftJoin('education_session', 'es', 'es.`id_education_session` = s.`id_education_session`');
		}

		$query->leftJoin('product', 'e', 'e.`id_product` = s.`id_product`');
		$query->leftJoin('gender_lang', 'gl', 'gl.`id_gender` = c.`id_gender` AND gl.`id_lang` = ' . $context->language->id);

		if ($this->use_education_device) {
			$query->leftJoin('education_supplies', 'esu', 'esu.`id_education_supplies` = s.`id_education_supplies` ');
		}

		$query->leftJoin('student_education_prerequis', 'sep', 'sep.`id_student_education` = s.`id_student_education` ');
		$query->where('s.deleted = 0');
		$query->orderBy('date_start DESC');

		$students = Db::getInstance(_EPH_USE_SQL_SLAVE_)->executeS($query);

		foreach ($students as &$student) {

			if ($student['pass_certif']) {
				$student['certif_state'] = '<div style="color:green"><i class="fa-duotone fa-check"></i></div>';
			} else {
				$student['certif_state'] = '<div style="color:red"><i class="fa-duotone fa-xmark"></i></div>';
			}

			$educations = Product::getEducationDetails($student['id_product'], $student['id_product_attribute'], false);

			foreach ($educations as $key => $value) {

				$student[$key] = $value;
			}

			$student['FinalPrice'] = $student['price'] * (1 + $student['rate'] / 100);

			if ($this->use_sale_agent) {
				$student['agent'] = '';

				if ($student['id_sale_agent'] > 0) {
					$agent = SaleAgent::getSaleAgentbyId($student['id_sale_agent']);
					$student['agent'] = $agent['firstname'] . ' ' . $agent['lastname'];
				}

			}

			if ($student['id_student_education_state'] > 6) {
				$student['connexionLenght'] = (int) str_replace(":", "", $student['education_lenghts']) > 0 ? 1 : 0;
				$time = strtotime($student['date_start']);

				$lenght = explode(":", $student['education_lenghts']);
				$time = Tools::convertTimetoHex($lenght[0], $lenght[1]);

				if ($student['hours'] > 0) {
					$student['ratio'] = round($time * 100 / $student['hours'], 2) . ' %';
				} else {
					$student['ratio'] = '0 %';
				}

			} else {
				$student['ratio'] = '0 %';
			}

			if (!Validate::isUnsignedId($student['id_student_education_prerequis'])) {
				$student['id_student_education_prerequis'] = 0;
			}

		}

		$request->request = Tools::jsonEncode($students, JSON_HEX_QUOT | JSON_HEX_TAG);

		if ($idRequest > 0) {
			$request->update();
		} else {
			$request->add();
		}

		return $students;

	}

	public function addArchive() {

		$context = Context::getContext();
		$query = new DbQuery();
		$query->select('s.*, sl.name, c.firstname, c.lastname, c.birthname, c.email, c.password, est.`name` as state, gl.name as title, cer.name as certificationName, sep.id_student_education_prerequis,  a.phone, a.phone_mobile, a.postcode, a.city');

		if ($this->use_session) {
			$query->select('es.name as `dateSession`, es.session_date');
		}

		if ($this->use_education_device) {
			$query->select('esu.name as supplyName');
		}

		if ($this->use_education_platform) {
			$query->select('e.id_platform as educationPlatform');
		}

		$query->from('student_education', 's');
		$query->leftJoin('student_education_lang', 'sl', 'sl.`id_student_education` = s.`id_student_education` AND sl.id_lang = ' . $context->language->id);
		$query->leftJoin('certification_lang', 'cer', 'cer.`id_certification` = s.`id_certification` AND cer.id_lang = ' . $context->language->id);
		$query->leftJoin('user', 'c', 'c.`id_user` = s.`id_user`');
		$query->innerJoin('address', 'a', 'a.`id_user` = c.`id_user`');
		$query->leftJoin('student_education_state_lang', 'est', 'est.`id_student_education_state` = s.`id_student_education_state` AND est.`id_lang` = ' . $context->language->id);

		if ($this->use_session) {
			$query->leftJoin('education_session', 'es', 'es.`id_education_session` = s.`id_education_session`');
		}

		$query->leftJoin('product', 'e', 'e.`id_product` = s.`id_product`');
		$query->leftJoin('gender_lang', 'gl', 'gl.`id_gender` = c.`id_gender` AND gl.`id_lang` = ' . $context->language->id);

		if ($this->use_education_device) {
			$query->leftJoin('education_supplies', 'esu', 'esu.`id_education_supplies` = s.`id_education_supplies` ');
		}

		$query->leftJoin('student_education_prerequis', 'sep', 'sep.`id_student_education` = s.`id_student_education` ');
		$query->where('s.deleted = 0');
		$query->where('s.id_student_education = ' . (int) $this->id);

		$newStudent = Db::getInstance()->getRow($query);
		$newStudent['certif_state'] = '<div style="color:red"><i class="fa-duotone fa-xmark"></i></div>';
		$educations = Product::getEducationDetails($newStudent['id_product'], $newStudent['id_product_attribute'], false);

		foreach ($educations as $key => $value) {
			$newStudent[$key] = $value;
		}

		$newStudent['FinalPrice'] = $newStudent['price'] * (1 + $newStudent['rate'] / 100);

		if ($this->use_sale_agent) {
			$newStudent['agent'] = '';

			if ($newStudent['id_sale_agent'] > 0) {
				$agent = SaleAgent::getSaleAgentbyId($newStudent['id_sale_agent']);
				$newStudent['agent'] = $agent['firstname'] . ' ' . $agent['lastname'];
			}

		}

		$newStudent['connexionLenght'] = 0;
		$newStudent['ratio'] = '0 %';

		if (!Validate::isUnsignedId($newStudent['id_student_education_prerequis'])) {
			$newStudent['id_student_education_prerequis'] = 0;
		}

		$idRequest = ParagridRequest::getRequestIdBy('StudentEducation');
		$request = new ParagridRequest($idRequest, $context->language->id);
		$students = $request->request;
		array_unshift($students, $newStudent);

		$request->request = Tools::jsonEncode($students, JSON_HEX_QUOT | JSON_HEX_TAG);
		$request->update();
	}

	public function removeArchive() {

		$context = Context::getContext();
		$newPieces = [];
		$idRequest = ParagridRequest::getRequestIdBy('StudentEducation');
		$request = new ParagridRequest($idRequest, $context->language->id);
		$students = $request->request;

		foreach ($students as &$student) {

			if ($student['id_student_education'] == $this->id) {
				continue;
			}

			$newPieces[] = $student;
		}

		$request->request = Tools::jsonEncode($newPieces, JSON_HEX_QUOT | JSON_HEX_TAG);
		$request->update();

	}

	public function getDateEnd() {

		$date = new DateTime($this->date_end);
		return $date->format("d/m/Y");
	}

	public function isHotAnswer() {

		return Db::getInstance()->getValue(
			(new DbQuery())
				->select('id_student_evaluation')
				->from('student_evaluation')
				->where('`id_student_education` = ' . $this->id_student_education)
				->where('`type` LIKE "hot" AND `answered` = 1')
		);
	}

	public function getHotScore() {

		return Db::getInstance()->getValue(
			(new DbQuery())
				->select('score')
				->from('student_evaluation')
				->where('`id_student_education` =' . $this->id_student_education)
				->where('`type` LIKE "hot" AND `answered` = 1')
		);
	}

	public function updateStudentlastEducation() {

		$student = new User($this->id_user);
		$student->cach_last_education = $this->id;
		$student->update();
	}

	public function sendStudentEmail() {

		$context = Context::getContext();
		$studentEducation = new StudentEducation($this->id);

		$step = $studentEducation->id_student_education_state;

		$template = StudentEducationStep::getTemplate($studentEducation->id_student_education_state, $context->language->id);
		$agentTemplate = StudentEducationStep::getAgentTemplate($studentEducation->id_student_education_state, $context->language->id);

		if (!empty($template['template'])) {
			$topic = StudentEducationStep::getTopic($studentEducation->id_student_education_state, $context->language->id);

			$customer = new User($studentEducation->id_user);
			$education = new Product($studentEducation->id_product);
			$date_start = $studentEducation->date_start;
			$fileAttachement = null;

			$attachement = Db::getInstance(_EPH_USE_SQL_SLAVE_)->getValue(
				(new DbQuery())
					->select('fileName')
					->from('education_programme')
					->where('`id_education` = ' . (int) $studentEducation->id_product)
					->where('`id_product_attribute` = ' . (int) $studentEducation->id_product_attribute)
			);

			if ($attachement != '') {
				$fileName = _EPH_PROGRAM_DIR_ . $attachement;

				if (file_exists($fileName)) {
					$fileAttachement[] = [
						'content' => chunk_split(base64_encode(file_get_contents($fileName))),
						'name'    => $attachement,
					];
				}

			}

			$tpl = $context->smarty->createTemplate(_EPH_MAIL_DIR_ . $template['template'] . '.tpl');
			$tpl->assign([
				'customer'         => $customer,
				'studentEducation' => $studentEducation,
				'is_video_tuto'    => Configuration::get('EPH_ALLOW_VIDEO_TUTO'),
				'tutoVideo'        => Configuration::get('EPH_TUTO_VIDEO'),

			]);
			$postfields = [
				'sender'      => [
					'name'  => sprintf($this->l("Administrative department of %s"), Configuration::get('EPH_SHOP_NAME')),
					'email' => Configuration::get('EPH_SHOP_EMAIL'),
				],
				'to'          => [
					[
						'name'  => $customer->firstname . ' ' . $customer->lastname,
						'email' => $customer->email,
					],
				],

				'subject'     => $topic,
				"htmlContent" => $tpl->fetch(),
				'attachment'  => $fileAttachement,
			];

			$result = Tools::sendEmail($postfields);
			$step = new StudentEducationStep($studentEducation->id_student_education_state, $context->language->id);

			if ($step->is_suivie == 1) {
				$suivie = new StudentEducationSuivie();
				$suivie->suivie_date = date('Y-m-d');
				$suivie->id_student_education = $education->id;
				$suivie->id_student_education_state = $step->id;
				$suivie->email_title = $topic;
				$suivie->email_content = $tpl->fetch();
				$suivie->content = $step->suivie;
				$suivie->add();

			}

		}

		if ($this->use_sale_agent && !empty($agentTemplate['template'])) {

			if ($studentEducation->id_sale_agent > 0) {
				$agent = new SaleAgent($studentEducation->id_sale_agent);

				if ($agent->sale_commission_amount > 0) {
					$topic = StudentEducationStep::getAgentTopic($studentEducation->id_student_education_state, $context->language->id);
					$student = new User($studentEducation->id_user);
					$education = new Education($studentEducation->id_education);
					$date_start = $studentEducation->date_start;
					$tpl = $context->smarty->createTemplate(_EPH_MAIL_DIR_ . $template['template'] . '.tpl');

					$tpl->assign([
						'student'          => $customer,
						'studentEducation' => $studentEducation,
						'agent_lastname'   => $agent->lastname,
						'agent_firstname'  => $agent->firstname,
						'agent_com'        => $agent->sale_commission_amount,
						'tutoVideo'        => Configuration::get('EPH_TUTO_VIDEO'),

					]);
					$postfields = [
						'sender'      => [
							'name'  => sprintf($this->l("Administrative department of %s"), Configuration::get('EPH_SHOP_NAME')),
							'email' => Configuration::get('EPH_SHOP_EMAIL'),
						],
						'to'          => [
							[
								'name'  => $agent->firstname . ' ' . $agent->lastname,
								'email' => $agent->email,
							],
						],
						'subject'     => $topic,
						"htmlContent" => $tpl->fetch(),
					];

					$result = Tools::sendEmail($postfields);

				}

			}

		}

	}

	public function getIdPrerequis() {

		return Db::getInstance()->getValue(
			(new DbQuery())
				->select('`id_student_education_prerequis`')
				->from('student_education_prerequis')
				->where('`id_student_education` = ' . $this->id)
		);
	}

	public function getAgent() {

		if ($this->id_sale_agent > 0) {
			$agent = new User($this->id_sale_agent);
			return $agent->firstname . ' ' . $agent->lastname;
		}

		return null;
	}

	public function getStudentFirstnamme() {

		$student = new User($this->id_user);
		return $student->firstname;
	}

	public function getStudentLastnamme() {

		$student = new User($this->id_user);
		return $student->lastname;
	}

	public function getStudentEmail() {

		$student = new User($this->id_user);
		return $student->email;
	}

	public function getStudentPhoneMobile() {

		$student = new User($this->id_user);

		$id_address = Address::getFirstCustomerAddressId($student->id);
		$address = new Address((int) $id_address);
		return $address->phone_mobile;
	}

	public function getRatio() {

		if ($this->hours > 0) {
			$lenght = explode(":", $this->education_lenghts);
			$time = Tools::convertTimetoHex($lenght[0], $lenght[1]);
			return round($time * 100 / $this->hours, 2);
		}

		return 0;
	}

	public function getDuration() {

		$duration = explode(":", $this->education_lenghts);
		return vsprintf("%sh %smin %s", $duration);
	}

	public function getState() {

		$context = Context::getContext();
		return Db::getInstance()->getValue(
			(new DbQuery())
				->select('`name`')
				->from('student_education_state_lang')
				->where('`id_student_education_state` = ' . $this->id_student_education_state)
				->where('`id_lang` = ' . $context->language->id)
		);
	}

	public function getSupply() {

		return Db::getInstance()->getValue(
			(new DbQuery())
				->select('`name`')
				->from('education_supplies')
				->where('`id_education_supplies` = ' . $this->id_education_supplies)
		);
	}

	public function getDateStart() {

		$date = new DateTime($this->date_start);
		return $date->format("d/m/Y");
	}

	public function getSessionDateName() {

		if ($this->id_education_session == 0 && !$this->use_education_device) {
			$Newdate = DateTime::createFromFormat('Y-m-d', $this->date_start);
			return sprintf($this->l('Session du %s'), Tool::convertinFrench($Newdate->format("d F Y")));
		} else
		if ($this->use_education_device) {
			return Db::getInstance()->getValue(
				(new DbQuery())
					->select('`name`')
					->from('education_session')
					->where('`id_education_session` = ' . $this->id_education_session)

			);
		}

	}
    
    public function setEducationHours() {
        
         $month = date("Y-m");
        
         $new_hours[$month] = Db::getInstance()->getValue(
			(new DbQuery())
             ->select('SUM(`hours`)')
			->from('student_education')
			->where('`id_student_education_state` > 6')
         );
         
         Configuration::updateValue('EPH_CURRENT_EDUCATION_HOURS', Tools::jsonEncode($new_hours)); 
	}
    
    public function setStudentNumber() {

        $month = date("Y-m");
        $new_number[$month] = Db::getInstance()->getValue(
			(new DbQuery())
				->select('COUNT(id_student_education)')
				->from('student_education')
				->where('`id_student_education_state` > 6')
		);
        
        Configuration::updateValue('EPH_CURRENT_STUDENT_NBRS', Tools::jsonEncode($new_number)); 
		
	}


	public static function getEducationHours() {
        
        $month = date("Y-m");
        $current_hours = Configuration::get('EPH_CURRENT_EDUCATION_HOURS') ? Configuration::get('EPH_CURRENT_EDUCATION_HOURS') : null;
        if(!is_null($current_hours)) {
            $score = Tools::jsonDecode(Configuration::get('EPH_CURRENT_EDUCATION_HOURS'), true);
            if(array_key_exists($month, $score)) {
                return $score[$month];
            }
        } else {

            $hours = 0;
            
            $studentEducations = new PhenyxCollection('StudentEducation');
            $studentEducations->where('id_student_education_state', '>', 6);

            foreach ($studentEducations as $studentEducation) {
                $hours = $hours + (int) $studentEducation->hours;
            }
            $new_hours[$month] = $hours;
            Configuration::updateValue('EPH_CURRENT_EDUCATION_HOURS', Tools::jsonEncode($new_hours)); 

            return $new_hours[$month];
        }

	}

	public static function getStudentNumber() {

        $month = date("Y-m");
        $current_number = Configuration::get('EPH_CURRENT_STUDENT_NBRS') ? Configuration::get('EPH_CURRENT_STUDENT_NBRS') : null;
        if(!is_null($current_number)) {
            $score = Tools::jsonDecode(Configuration::get('EPH_CURRENT_STUDENT_NBRS'), true);
            if(array_key_exists($month, $score)) {
                return $score[$month];
            }
        } else {
            $new_number[$month] = null;
            $studentEducations = new PhenyxCollection('StudentEducation');
		    $studentEducations->where('id_student_education_state', '>', 6);
            $new_number[$month] = count($studentEducations);
            Configuration::updateValue('EPH_CURRENT_STUDENT_NBRS', Tools::jsonEncode($new_number)); 
		    return $new_number;

        }
		
	}

	public static function isSessionValidate($id_education_session) {

		return Db::getInstance()->getValue(
			(new DbQuery())
				->select('COUNT(`id_student_education`)')
				->from('student_education')
				->where('`id_education_session` = ' . $id_education_session)
				->where('`id_student_education_state` < 3 ')
				->where('`deleted` = 0')
		);

	}

	public static function getNbAttendees($idEducationSession) {

		return Db::getInstance()->getValue(
			(new DbQuery())
				->select('COUNT(`id_student_education`)')
				->from('student_education')
				->where('`id_education_session` = ' . $idEducationSession)
				->where('`deleted` = 0')
		);
	}

	public static function getSessionTurnover($idEducationSession) {

		return Db::getInstance()->getValue(
			(new DbQuery())
				->select('SUM(`price`)')
				->from('student_education')
				->where('`id_education_session` = ' . $idEducationSession)
				->where('`id_student_education_state` >= 4')
				->where('`deleted` = 0')
		);
	}

	public static function getSessionExpectedTurnover($idEducationSession) {

		return Db::getInstance()->getValue(
			(new DbQuery())
				->select('SUM(`price`)')
				->from('student_education')
				->where('`id_education_session` = ' . $idEducationSession)
				->where('`id_student_education_state` <= 3')
				->where('`deleted` = 0')
		);
	}

	public static function getSessionbyIdSession($idEducationSession) {

		return Db::getInstance()->executeS(
			(new DbQuery())
				->select('`id_student_education`')
				->from('student_education')
				->where('`id_education_session` = ' . $idEducationSession)
				->where('`deleted` = 0')
		);
	}

	public static function getFilledSession() {

		return Db::getInstance()->executeS(
			(new DbQuery())
				->select('DISTINCT(`id_education_session`)')
				->from('student_education')
				->where('`deleted` = 0')
		);

	}

	public static function getFilledSessionbyId($id_education_session) {

		return Db::getInstance()->executeS(
			(new DbQuery())
				->select('DISTINCT(`id_education_session`)')
				->from('student_education')
				->where('`deleted` = 0')
				->where('`deleted` = 0')
		);

	}

	
	public static function getStudentEducationsbyIdStudent($idStudent, $identifiant) {

		$sql = new DbQuery();
		$sql->select('id_student_education');
		$sql->from(bqSQL(static::$definition['table']));
		$sql->where('`id_user` = ' . (int) $idStudent);
		$sql->where('`id_platform` = ' . $identifiant);
		$sql->where('`deleted` = 0');
		$sql->orderBy("id_student_education DESC");

		return Db::getInstance(_EPH_USE_SQL_SLAVE_)->getValue($sql);
	}

	public static function getLastAlterIndex() {

		$platform = New Platform(1);
		$data_array = [
			"orderBy" => "idGroupe",
		];

		$token = $platform->plarform_token;
		$curl = new Curl();
		$curl->setDefaultJsonDecoder($assoc = true);
		$curl->setHeader('Content-Type', 'application/json');
		$curl->setHeader('token', $token);
		$curl->post($platform->webservice_link . 'nj/groups/getAllInList', Tools::jsonEncode($data_array));
		$response = $curl->response;

		$groups = [];

		foreach ($response as $group) {

			if ($group["idGroupe"] == 3) {
				continue;
			}

			$groupName = explode("-", $group["libelleGroupe"]);

			$groups[] = $groupName[0];

		}

		return (int) max($groups) + 1;
	}

	public static function createAlterGroup($libelleGroupe) {

		$platform = New Platform(1);
		$data_array = [
			"libelleGroupe" => $libelleGroupe,
			"groupeProtege" => 0,
			"idParent"      => 3,

		];

		$token = $platform->plarform_token;
		$curl = new Curl();
		$curl->setDefaultJsonDecoder($assoc = true);
		$curl->setHeader('Content-Type', 'application/json');
		$curl->setHeader('token', $token);
		$curl->post($platform->webservice_link . 'nj/groups/create', Tools::jsonEncode($data_array));
		$response = $curl->response;

		return $response['idGroupe'];

	}

	public static function createAlterUser($dataUser) {

		$platform = New Platform(1);
		$token = $platform->plarform_token;
		$curl = new Curl();
		$curl->setDefaultJsonDecoder($assoc = true);
		$curl->setHeader('Content-Type', 'application/json');
		$curl->setHeader('token', $token);
		$curl->post($platform->webservice_link . 'nj/users/create', Tools::jsonEncode($dataUser));
		return $curl->response;

	}

	public static function createCloudUser($datauser) {

		$platform = New Platform(3);

		if (!($platform->has_webservice)) {
			return true;
		}

		$curl = new Curl();
		$curl->setHeader('Content-Type', 'multipart/form-data');
		$curl->setHeader('Access-Token', $platform->plarform_token);
		$curl->get('https://cloudelearning.eu/php5/restapi/utilisateur/inscription', $dataUser);
		$response = $curl->response;
		$result = json_encode($response);
		return json_decode($result, true);

	}

	public static function synchCloudLearning($idSession) {

		$platform = New Platform(3);

		if (!($platform->has_webservice)) {
			return true;
		}

		$session = new EducationSession($idSession);

		$date_start = $session->session_date;
		$date = new DateTime($date_start);
		$date->modify('+1 year');
		$date_end = $date->format('Y-m-d');

		$context = Context::getContext();

		$educations = Db::getInstance(_EPH_USE_SQL_SLAVE_)->executeS(
			(new DbQuery())
				->select('s.id_student_education, st.firstname, st.lastname, st.email,  s.identifiant, s.passwd_link, gl.name as title, eal.name, ea.id_platforme as idSession')
				->from('student_education', 's')
				->leftJoin('user', 'st', 'st.`id_user` = s.`id_user`')
				->leftJoin('product', 'e', 'a.`id_product` = s.`id_product`')
				->leftJoin('product_attribute', 'ea', 'ea.`id_product_attribute` = s.`id_product_attribute` AND ea.`id_product` = s.`id_product`')
				->leftJoin('platform', 'p', 'p.`id_platform` = e.`id_platform`')
				->leftJoin('gender_lang', 'gl', 'gl.`id_gender` = st.`id_gender` AND gl.id_lang = ' . $context->language->id)
				->leftJoin('education_attribute_lang', 'eal', 'eal.`id_product_attribute` = s.`id_product_attribute` AND eal.`id_lang` = ' . $context->language->id)
				->where('s.deleted = 0')
				->where('p.id_platform = ' . $platform->id)
				->where('s.id_platform = 0')
				->where('s.id_student_education_state > 2')
				->where('s.id_education_session = ' . (int) $session->id)
				->orderBy('s.id_product_attribute')
		);

		foreach ($educations as $stagiaire) {
			$studentEducation = new StudentEducation($stagiaire['id_student_education']);
			$student = new User($studentEducation->id_user);
			$dataUser = [
				'nom'        => $student->lastname,
				'prenom'     => $student->firstname,
				'civilite'   => $student->id_gender,
				'login'      => $student->email,
				'pwd'        => $student->password,
				'email'      => $student->email,
				'date_debut' => $date_start,
				'date_fin'   => $date_end,
			];

			$response = StudentEducation::createCloudUser($datauser);

			$studentEducation->id_platform = $response['guid'];
			$studentEducation->update();

			$plugins = EducationPlugin::getPluginsbyEducationId($studentEducation->id_product, $studentEducation->id_product_attribute);

			$dataUser = [
				'utilisateur'      => $studentEducation->id_platform,
				'plugins'          => $plugins,
				'affect_eval_pre'  => 1,
				'affect_eval_post' => 1,
			];

			$curl = new Curl();
			$curl->setHeader('Content-Type', 'multipart/form-data');
			$curl->setHeader('Access-Token', $platform->plarform_token);
			$curl->post('https://cloudelearning.eu/php5/restapi/catalogue/affect-formations', $dataUser);
			$response = $curl->response;

		}

	}

	public static function syncAlterSession($idSession) {

		$session = new EducationSession($idSession);

		$platform = New Platform(1);

		$month = [];
		$month["January"] = "JANVIER";
		$month["February"] = "FEVRIER";
		$month["March"] = "MARS";
		$month["April"] = "AVRIL";
		$month["May"] = "MAI";
		$month["June"] = "JUIN";
		$month["July"] = "JUILLET";
		$month["August"] = "AOUT";
		$month["September"] = "SEPTEMBRE";
		$month["October"] = "OCTOBRE";
		$month["November"] = "NOVEMBRE";
		$month["December"] = "DECEMBRE";
		$file = fopen("testsyncAlterSession.txt", "w");
		$sessionIndex = StudentEducation::getLastAlterIndex();
		fwrite($file, $sessionIndex . PHP_EOL);

		$AlterSession = $sessionIndex . "-" . date("Y") . ' ';
		$date = new DateTime($session->session_date);
		$dateStart = $date->format("d/m/Y");

		$dateIsoStart = $date->format("Y-m-d H:i:s");
		$AlterSession .= $date->format("d") . ' ';
		$AlterSession .= $month[$date->format("F")] . ' AU ';
		$date->modify('+30 days');
		$AlterSession .= $date->format("d") . ' ';
		$AlterSession .= $month[$date->format("F")];
		$date->modify('-30 days');
		$date->modify('+1 year');
		$date_end = $date->format('d/m/Y');
		$dateIsoEnd = $date->format("Y-m-d H:i:s");

		if ($session->id_alter == 0) {
			$session->id_alter = StudentEducation::createAlterGroup($AlterSession);
			$session->update();
		}

		$context = Context::getContext();

		$educations = Db::getInstance(_EPH_USE_SQL_SLAVE_)->executeS(
			(new DbQuery())
				->select('s.id_student_education, st.firstname, st.lastname, st.email, s.identifiant, s.passwd_link, gl.name as title, eal.name, ea.id_plateforme as idSession')
				->from('student_education', 's')
				->leftJoin('user', 'st', 'st.`id_user` = s.`id_user`')
				->leftJoin('product', 'e', 'e.`id_product` = s.`id_product`')
				->leftJoin('product_attribute', 'ea', 'ea.`id_product_attribute` = s.`id_product_attribute` AND ea.`id_product` = s.`id_product`')
				->leftJoin('platform', 'p', 'p.`id_platform` = e.`id_platform`')
				->leftJoin('gender_lang', 'gl', 'gl.`id_gender` = st.`id_gender` AND gl.id_lang = ' . $context->language->id)
				->leftJoin('product_attribute_lang', 'eal', 'eal.`id_product_attribute` = s.`id_product_attribute` AND eal.`id_lang` = ' . $context->language->id)
				->where('s.deleted = 0')
				->where('p.id_platform = ' . $platform->id)
				->where('s.id_student_education_state > 2')
				->where('s.id_education_session = ' . (int) $session->id)
				->orderBy('s.id_product_attribute')
		);

		foreach ($educations as $stagiaire) {
			$studentEducation = new StudentEducation($stagiaire['id_student_education']);

			if ($studentEducation->id_platform == 0) {
				$user = [
					"civilite"       => $stagiaire['title'],
					"nom"            => $stagiaire['lastname'],
					"prenom"         => $stagiaire['firstname'],
					"email"          => $stagiaire['email'],
					"utilProtege"    => 0,
					"compteActif"    => 1,
					"idGroupe"       => $session->id_alter,
					"identifiant"    => $stagiaire['identifiant'],
					"actifApartirDe" => $dateIsoStart,
					"actifJusqua"    => $dateIsoEnd,
					'actifApartirDe' => $dateIsoStart,
					"actifJusqua"    => $dateIsoEnd,
				];

				$response = StudentEducation::createAlterUser($user);
				fwrite($file, print_r($response, true) . PHP_EOL);
				$studentEducation->id_platform = $response['idUtilisateur'];
				$studentEducation->passwd_link = $response['motDePasse'];
				$idPlateforms = explode(",", $stagiaire['idSession']);

				if (is_array($idPlateforms) && count($idPlateforms)) {

					foreach ($idPlateforms as $idPlateform) {

						$dataSession = [
							"idUtilisateur" => $studentEducation->id_platform,
							"idSession"     => $idPlateform,
							"dateDebut"     => $dateIsoStart,
							"dateFin"       => $dateIsoEnd,
						];
						$token = $platform->plarform_token;
						$curl = new Curl();
						$curl->setDefaultJsonDecoder($assoc = true);
						$curl->setHeader('Content-Type', 'application/json');
						$curl->setHeader('token', $token);
						$curl->post($platform->webservice_link . 'nj/affectation/createSessionToUser', Tools::jsonEncode($dataSession));
					}

				}

				$studentEducation->update();
			}

		}

	}

	public function synchroAlterCampus() {

		$platform = new Platform(1);
		$data_array = [];
		$students = [];
		$today = date('Y-m-d');
		$date1 = date_create($today);
		$token = $platform->plarform_token;
		$curl = new Curl();
		$curl->setDefaultJsonDecoder($assoc = true);
		$curl->setHeader('Content-Type', 'application/json');
		$curl->setHeader('token', $token);
		$curl->post($platform->webservice_link . 'nj/users/getAllInList', Tools::jsonEncode($data_array));
		$response = $curl->response;

		foreach ($response as &$user) {
			$date = $user['actifApartirDe'];
			$user['actifApartirDe'] = date('Y-m-d', strtotime($date));
			$date2 = date_create($user['actifApartirDe']);
			$diff = date_diff($date1, $date2);
			$days = $diff->format("%a");

			if ($today > $user['actifApartirDe'] && $days < 60) {
				$students[] = $user;
			}

		}

		foreach ($students as $student) {

			$actifApartirDe = $student['actifApartirDe'];
			$identifiant = $student["idUtilisateur"];

			if ((int) $student['matricule'] > 0) {

				$idStudentEducation = $student['matricule'];

			} else {

				$idStudent = User::getStudentbyEmail($student['email']);
				$idStudentEducation = StudentEducation::getStudentEducationsbyIdStudent($idStudent, $identifiant);

				if ($idStudentEducation > 0) {
					$dataUtilisateur = [
						'idUtilisateur' => $student['idUtilisateur'],
					];
					$curl = new Curl();
					$curl->setDefaultJsonDecoder($assoc = true);
					$curl->setHeader('Content-Type', 'application/json');
					$curl->setHeader('token', $token);
					$curl->post($platform->webservice_link . 'nj/users/update', Tools::jsonEncode($dataUtilisateur));
					$response = $curl->response;

				}

			}

			if ($idStudentEducation > 0) {
				$dataUtilisateur = [
					'idUtilisateur' => $student['idUtilisateur'],
				];
				$curl = new Curl();
				$curl->setDefaultJsonDecoder($assoc = true);
				$curl->setHeader('Content-Type', 'application/json');
				$curl->setHeader('token', $token);
				$curl->post($platform->webservice_link . 'nj/resultats/autoFormationDetailsUtilisateur', Tools::jsonEncode($dataUtilisateur));
				$UserResponse = $curl->response;
				$education_lenghts = '00:00:00';

				if (isset($UserResponse['resultat'][0]['tempsPasseTotal'])) {
					$education_lenghts = $UserResponse['resultat'][0]['tempsPasseTotal'];
					$pos = strpos($education_lenghts, 'min');

					if ($pos === false) {
						$education_lenghts = str_replace('h', ':', $education_lenghts) . ':00';
					}

				}

				if ($education_lenghts != '00:00:00') {
					$dateDebut = $UserResponse['resultat'][0]['tabSessions'][0]['dateDebut'];
					$date = date_create_from_format('Y-m-d H:i:s', $dateDebut);
					$firstConnection = $date->format('Y-m-d');
				} else {
					$firstConnection = '0000-00-00';
				}

				$studentEducation = new StudentEducation($idStudentEducation);

				if ($firstConnection != '0000-00-00' && $studentEducation->id_student_education_state < 7) {
					StudentEducation::changeEducationStepId($studentEducation->id, 7);
					$studentEducation->id_student_education_state = 7;
				}

				$studentEducation->id_platform = $student['idUtilisateur'];
				$studentEducation->first_connection = $firstConnection;
				$studentEducation->education_lenghts = $education_lenghts;
				$studentEducation->update(false, false);
			}

		}
       // $this->compileArchive();
		return true;

	}

	public function indexEducation() {

		$context = Context::getContext();
		$today = date("Y-m-d");


		$date = new DateTime($today);
		$date->modify('-7 days');
		$dateCheck = $date->format('Y-m-d');

		if ($this->use_session) {
			$sessionCheck = Db::getInstance()->getValue(
				(new DbQuery())
					->select('`id_education_session`')
					->from('education_session')
					->where('`session_date` = \'' . $dateCheck . '\'')
			);
		} else {
			$sessionCheck = Db::getInstance()->executeS(
				(new DbQuery())
					->select('`id_student_education`')
					->from('student_education')
					->where('`date_start` = \'' . $dateCheck . '\'')
			);
		}

		if (isset($sessionCheck) && $sessionCheck > 0) {
			$this->proceedEducationCheck($sessionCheck);
		}

		$date = new DateTime($today);
		$date->modify('-120 days');
		$dateEvalColdCheck = $date->format('Y-m-d');

		if ($this->use_session) {
			$sessionEvalCodCheck = Db::getInstance()->getValue(
				(new DbQuery())
					->select('`id_education_session`')
					->from('education_session')
					->where('`session_date` = \'' . $dateEvalColdCheck . '\'')
			);

			if (isset($sessionEvalCodCheck) && $sessionEvalCodCheck > 0) {
				$session = new EducationSession($sessionEvalCodCheck);

				$sessionDetails = Db::getInstance()->executeS(
					(new DbQuery())
						->select('`id_student_education`')
						->from('student_education')
						->where('`id_education_session` = ' . $session->id)
						->where('`deleted` = 0')
						->where('`eval_cold` = 0')
						->where('`isLaunch` = 1')
				);

				$ts1 = strtotime($today);
				$year1 = date('Y', $ts1);
				$month1 = date('m', $ts1);

				foreach ($sessionDetails as $sessionDetail) {

					$studentEducation = new StudentEducation($sessionDetail['id_student_education']);
					//self::sendEvaluationCold($studentEducation);
				}

			}

		} else {
			$sessionEvalCodCheck = Db::getInstance()->getValue(
				(new DbQuery())
					->select('`id_student_education`')
					->from('student_education')
					->where('`date_start` = \'' . $dateEvalColdCheck . '\'')
			);
		}

	}

	public static function checkColdEvaluation() {

		$context = Context::getContext();
		$today = date("Y-m-d");
		$date = new DateTime($today);
		$date->modify('-150 days');
		$dateCheck = $date->format('Y-m-d');
		$today = date("Y-m-d");
		$date->modify('-270 days');
		$curentDateStart = $date->format('Y-m-d');
		$studentEducations = Db::getInstance()->executeS(
			(new DbQuery())
				->select('`id_student_education`')
				->from('student_education')
				->where('`deleted` = 0')
				->where('`eval_cold` = 0')
				->where('`date_end` < \'' . $dateCheck . '\'')
				->where('`date_start` > \'' . $curentDateStart . '\'')
		);

		foreach ($studentEducations as $studentEducation) {
			$studentEducation = new StudentEducation($studentEducation['id_student_education']);
			//StudentEducation::sendEvaluationCold($studentEducation);
		}

	}

	public static function sendEvaluationCold(StudentEducation $studentEducation) {

		$context = Context::getContext();
		$today = date("Y-m-d");
		$ts1 = strtotime($today);
		$year1 = date('Y', $ts1);
		$month1 = date('m', $ts1);
		$ts2 = strtotime($studentEducation->date_end);
		$year2 = date('Y', $ts2);
		$month2 = date('m', $ts2);
		$diff = (($year1 - $year2) * 12) + ($month1 - $month2);
		$student = new User($studentEducation->id_user);
		$secret_iv = _COOKIE_KEY_;
		$secret_key = _PHP_ENCRYPTION_KEY_;
		$string = $student->id . '-' . $student->lastname . $student->secure_key;
		$crypto_key = Tools::encrypt_decrypt('encrypt', $string, $secret_key, $secret_iv);
		$linkEval = $context->link->getPageLink('index', true, $context->language->id, ['crypto_key' => $crypto_key, 'idStudentEducation' => $studentEducation->id]) . '&submitEvalCold';
		$tpl = $context->smarty->createTemplate(_EPH_MAIL_DIR_ . 'cold_evaluation.tpl');
		$tpl->assign([
			'customer'         => $student,
			'diff'             => $diff,
			'studentEducation' => $studentEducation,
			'linkEval'         => $linkEval,
		]);

		$htmlContent = $tpl->fetch();
		$postfields = [
			'sender'      => [
				'name'  => "Service  Administratif " . Configuration::get('EPH_SHOP_NAME'),
				'email' => Configuration::get('EPH_SHOP_EMAIL'),
			],
			'to'          => [
				[
					'name'  => $student->firstname . ' ' . $student->lastname,
					'email' => $student->email,
				],
			],
			'cc'          => [
				[
					'name'  => "Service  Administratif " . Configuration::get('EPH_SHOP_NAME'),
					'email' => Configuration::get('EPH_SHOP_EMAIL'),
				],
			],
			'subject'     => 'Votre avis suite à votre formation  "' . $studentEducation->name . '"',
			"htmlContent" => $htmlContent,
		];

		$result = Tools::sendEmail($postfields);

		$suivie = new StudentEducationSuivie();
		$suivie->suivie_date = $today;
		$suivie->id_student_education = $studentEducation->id;
		$suivie->email_title = 'Votre avis suite à votre formation "' . $studentEducation->name . '"';
		$suivie->email_content = $htmlContent;
		$suivie->id_student_education_state = 0;
		$suivie->content = 'Le questionnaire à froid a été envoyé à l’étudiant';
		$suivie->add();

	}

	public function proceedEducationRegistration() {

		$context = Context::getContext();
		$today = date("Y-m-d");
		$date = new DateTime($today);
		$date->modify('+16 days');
		$dateLimit = $date->format('Y-m-d');
		$sessionDetails = Db::getInstance()->executeS(
			(new DbQuery())
				->select('`id_student_education`')
				->from('student_education')
				->where('`date_start` = \'' . $dateLimit . '\'')
				->where('`deleted` = 0')
				->where('`id_student_education_state` = 2')
		);

		$idLang = Configuration::get('EPH_LANG_DEFAULT');

		foreach ($sessionDetails as $sessionDetail) {

			$studentEducation = new StudentEducation($sessionDetail['id_student_education'], $idLang);

			$student = new User($studentEducation->id_user);
			$reservationLink = $studentEducation->reservation_link;
			$tpl = $context->smarty->createTemplate(_EPH_MAIL_DIR_ . 'student_close_alert.tpl');
			$tpl->assign([
				'customer'         => $student,
				'reservationLink'  => $reservationLink,
				'studentEducation' => $studentEducation,
			]);

			$postfields = [
				'sender'      => [
					'name'  => sprintf($this->l("Administrative department of %s"), Configuration::get('EPH_SHOP_NAME')),
					'email' => Configuration::get('EPH_SHOP_EMAIL'),
				],
				'to'          => [
					[
						'name'  => $student->firstname . ' ' . $student->lastname,
						'email' => $student->email,
					],
				],

				'subject'     => sprintf($this->l('Reminder, you must register for your training %s '), $studentEducation->name),
				"htmlContent" => $tpl->fetch(),
			];

			$result = Tools::sendEmail($postfields);

			$context->smarty->assign(
				[
					'student'          => $student,
					'studentEducation' => $studentEducation,
				]
			);

			$content = $context->smarty->fetch(_EPH_SMS_DIR_ . 'educationLastDay.tpl');

			$recipient = $student->phone_mobile;
			Tool::sendSms($recipient, $content);

			if ($this->use_sale_agent && $studentEducation->id_sale_agent > 0) {

				$agent = new SaleAgent($studentEducation->id_sale_agent);

				if ($agent->sale_commission_amount > 0) {

					$tpl = $context->smarty->createTemplate(_EPH_MAIL_DIR_ . 'agent_close_remind.tpl');

					$tpl->assign([
						'student' => $student,
						'agent'   => $agent,
					]);
					$postfields = [
						'sender'      => [
							'name'  => sprintf($this->l("Administrative department of %s"), Configuration::get('EPH_SHOP_NAME')),

							'email' => Configuration::get('EPH_SHOP_EMAIL'),
						],
						'to'          => [
							[
								'name'  => $agent->firstname . ' ' . $agent->lastname,
								'email' => $agent->email,
							],
						],

						'subject'     => sprintf($this->l('Reminder, your %s training student must register en '), $studentEducation->name),
						"htmlContent" => $tpl->fetch(),
					];

					$result = Tools::sendEmail($postfields);
				}

			}

			$studentEducation->educLaunch = 1;
			$studentEducation->update(false, false);

		}
        //$this->compileArchive();

	}

	public function proceedEducationLaunch() {

		$context = Context::getContext();

		$today = date("Y-m-d");

		$date = new DateTime($today);
		$dateToday = date_create($today);
		$date->modify('+1 days');
		$dateLaunch = $date->format('Y-m-d');

		$sessionDetails = Db::getInstance()->executeS(
			(new DbQuery())
				->select('`id_student_education`')
				->from('student_education')
				->where('`date_start` = \'' . $dateLaunch . '\'')
				->where('`deleted` = 0')
				->where('`educLaunch` = 0')
				->where('`id_student_education_state` = 4')
		);

		$fileAttachement[] = [
			'content' => chunk_split(base64_encode(file_get_contents(_EPH_DOCUMENT_DIR_ . 'deontologie.pdf'))),
			'name'    => $this->l('Commitment - Code of ethics.pdf'),
		];
		$fileAttachement[] = [
			'content' => chunk_split(base64_encode(file_get_contents(_EPH_DOCUMENT_DIR_ . 'reglement.pdf'))),
			'name'    => $this->l('Commitment - Internal Rules.pdf'),
		];
		$idLang = Configuration::get('EPH_LANG_DEFAULT');

		foreach ($sessionDetails as $sessionDetail) {

			$studentEducation = new StudentEducation($sessionDetail['id_student_education'], $idLang);
            if ($this->use_session) {
                $id_education_session = $studentEducation->id_education_session;
            }

			if ($studentEducation->educLaunch == 1) {
				continue;
			}

			$student = new User($studentEducation->id_user);

			$tpl = $context->smarty->createTemplate(_EPH_MAIL_DIR_ . 'education_launch.tpl');

			$tpl->assign([
				'customer'         => $student,
				'studentEducation' => $studentEducation,
				'referent'         => Configuration::get('EPH_HANDICAP_REFERENT'),
			]);

			$postfields = [
				'sender'      => [
					'name'  => sprintf($this->l("Administrative department of %s"), Configuration::get('EPH_SHOP_NAME')),
					'email' => Configuration::get('EPH_SHOP_EMAIL'),
				],
				'to'          => [
					[
						'name'  => $student->firstname . ' ' . $student->lastname,
						'email' => $student->email,
					],
				],
				'subject'     => sprintf($this->l('Your %s training will start soon'), $studentEducation->name),
				"htmlContent" => $tpl->fetch(),
				'attachment'  => $fileAttachement,
			];

			$result = Tools::sendEmail($postfields);
			$credits = Tool::getSendInBlueSmsCredit();

			if ($credits > 0) {
				$context->smarty->assign(
					[
						'student'          => $student,
						'studentEducation' => $studentEducation,
					]
				);
				$content = $context->smarty->fetch(_EPH_SMS_DIR_ . 'educationLaunch.tpl');
				$recipient = $student->phone_mobile;
				Tool::sendSms($recipient, $content);
			}

			$studentEducation->educLaunch = 1;
			$studentEducation->update(false, false);
			StudentEducation::changeEducationStepId($studentEducation->id, 5);

		}

		if ($this->use_session && is_array($sessionDetails) && count($sessionDetails)) {
			$session = new EducationSession($id_education_session);
			$session->educLaunch = 1;
			$session->update();
		}
       // $this->compileArchive();

	}

	public function proceedEducationCheck($idSession) {

		$context = Context::getContext();

		if ($this->use_session) {
			$session = new EducationSession($idSession);

			$sessionDetails = Db::getInstance()->executeS(
				(new DbQuery())
					->select('`id_student_education`')
					->from('student_education')
					->where('`id_education_session` = ' . $session->id)
					->where('`deleted` = 0')
					->where('`isLaunch` = 1')
			);
		} else {
			$sessionDetails = $idSession;
		}

		foreach ($sessionDetails as $sessionDetail) {
			$studentEducation = new StudentEducation($sessionDetail['id_student_education'], $context->language->id);
			$connexionLenght = (int) str_replace(":", "", $studentEducation->education_lenghts);

			if ($connexionLenght > 0) {
				continue;
			}

			$student = new User($studentEducation->id_user);

			$tpl = $context->smarty->createTemplate(_EPH_MAIL_DIR_ . 'student_connexion_remind.tpl');

			$education = new Product($studentEducation->id_product);

			$tpl->assign([
				'customer'         => $student,
				'education'        => $education,
				'studentEducation' => $studentEducation,
			]);

			$postfields = [
				'sender'      => [
					'name'  => sprintf($this->l("Administrative department of %s"), Configuration::get('EPH_SHOP_NAME')),
					'email' => Configuration::get('EPH_SHOP_EMAIL'),
				],
				'to'          => [
					[
						'name'  => $student->firstname . ' ' . $student->lastname,
						'email' => $student->email,
					],
				],

				'subject'     => sprintf($this->l("Don't forget to log in to your %s training"), $studentEducation->date_begin),
				"htmlContent" => $tpl->fetch(),
			];

			$result = Tools::sendEmail($postfields);
		}

	}

	public function proceedSessionStart() {

		$context = Context::getContext();

		$today = date("Y-m-d");

		$sessionDetails = Db::getInstance()->executeS(
			(new DbQuery())
				->select('`id_student_education`')
				->from('student_education')
				->where('`date_start` = \'' . $today . '\'')
				->where('`deleted` = 0')
				->where('`isLaunch` = 0')
				->where('`id_student_education_state` > 3')
				->where('`id_student_education_state` != 10')
		);

		foreach ($sessionDetails as $sessionDetail) {

			$studentEducation = new StudentEducation($sessionDetail['id_student_education'], $context->language->id);

			if ($studentEducation->educationType == 2) {
				continue;
			}

			$education = new Product($studentEducation->id_product);

			$student = new User($studentEducation->id_user);

			$tpl = $context->smarty->createTemplate(_EPH_MAIL_DIR_ . 'convocation.tpl');

			$tpl->assign([
				'customer'         => $student,
				'education'        => $education,
				'studentEducation' => $studentEducation,
				'referent'         => Configuration::get('EPH_HANDICAP_REFERENT'),
			]);

			$postfields = [
				'sender'      => [
					'name'  => sprintf($this->l("Administrative department of %s"), Configuration::get('EPH_SHOP_NAME')),
					'email' => Configuration::get('EPH_SHOP_EMAIL'),
				],
				'to'          => [
					[
						'name'  => $student->firstname . ' ' . $student->lastname,
						'email' => $student->email,
					],
				],
				'subject'     => sprintf($this->l('Invitation to your training on %s'), $studentEducation->date_begin),
				"htmlContent" => $tpl->fetch(),
			];

			$result = Tools::sendEmail($postfields);

			$studentEducation->isLaunch = 1;
			$studentEducation->id_student_education_state = 6;
			$studentEducation->update(false, false);

			$suivie = new StudentEducationSuivie();
			$suivie->suivie_date = date('Y-m-d');
			$suivie->id_student_education = $studentEducation->id;
			$suivie->id_student_education_state = 6;
			$suivie->email_title = sprintf($this->l('Invitation to your training on %s'), $studentEducation->date_begin);
			$suivie->email_content = $tpl->fetch();
			$suivie->content = $step->suivie;
			$suivie->add();

		}
        //$this->compileArchive();

	}

	public function generateInvoice() {

		$today = date("Y-m-d");
        $date = new DateTime($today);
        $date->modify('-2 days');
		$dateInvoice = $date->format('Y-m-d');
        $sessionDetails = Db::getInstance()->executeS(
            (new DbQuery())
			->select('`id_student_education`')
			->from('student_education')
			->where('`date_end` = \'' . $dateInvoice . '\'')
			->where('`deleted` = 0')
			->where('id_student_education_state < 8')
        );

		

		foreach ($sessionDetails as $sessionDetail) {
			$studentEducation = new StudentEducation($sessionDetail['id_student_education']);

			if ($studentEducation->is_invoice == 1) {
				continue;
			}

			CustomerPieces::mergeOrderTable($studentEducation->id);
			$studentEducation->id_student_education_state = 9;
			$studentEducation->is_invoice = 1;
			$studentEducation->update(false, false);
			$suivie = new StudentEducationSuivie();
			$suivie->suivie_date = date('Y-m-d');
			$suivie->id_student_education = $studentEducation->id;
			$suivie->id_student_education_state = 9;
			$suivie->content = $this->l('The invoice was automatically generated');
			$suivie->add();
		}
        
       // $this->compileArchive();

	}

	public function proceedSessionEnd() {

        $today = date("Y-m-d");
        $file = fopen("testproceedSessionEnd.txt","w");
        $sessionDetails = Db::getInstance()->executeS(
            (new DbQuery())
			->select('`id_student_education`')
			->from('student_education')
			->where('`date_end` = \'' . $today . '\'')
			->where('`deleted` = 0')
			->where('id_student_education_state < 8')
        );
        

		$idLang = Configuration::get('EPH_LANG_DEFAULT');
        $this->context->language->id = $idLang;
        fwrite($file,"id lang".$idLang.PHP_EOL);

		$mailAgent = [];
        
        $step = new StudentEducationStep(8, $idLang);

		foreach ($sessionDetails as $sessionDetail) {

			$studentEducation = new StudentEducation($sessionDetail['id_student_education'], $idLang);
            fwrite($file,print_r($studentEducation, true).PHP_EOL);
			$educationName = $studentEducation->getEducationName($idLang);
			$time = (int) str_replace(":", "", $studentEducation->education_lenghts);
			$template = "";

			$education = new Product($studentEducation->id_product);
			$student = new User($studentEducation->id_user);

			$studentEducation->id_student_education_state = 8;

			$studentEducation->update(false, false);
            if ($this->use_session) {
                $session = new EducationSession($studentEducation->id_education_session);
			    $session->sessionEnded = 1;
                $session->update();
            }

			if ($time > 0) {

				$evaluation = new StudentEvaluation();
				$evaluation->id_user = $student->id;
				$evaluation->id_student_education = $studentEducation->id;
				$evaluation->type = 'hot';
				$evaluation->add();

				$tpl = $this->context->smarty->createTemplate(_EPH_MAIL_DIR_ . 'attestation_formation.tpl');

				$secret_iv = _COOKIE_KEY_;
				$secret_key = _PHP_ENCRYPTION_KEY_;
				$string = $student->id . '-' . $student->lastname . $student->secure_key;
				$crypto_key = Tools::encrypt_decrypt('encrypt', $string, $secret_key, $secret_iv);
				$linkEval = $this->context->link->getPageLink('index', true, $this->context->language->id, ['crypto_key' => $crypto_key, 'idStudentEducation' => $studentEducation->id, 'idEvaluation' => $evaluation->id]) . '&submitEvalHot';

				$tpl->assign([
					'customer'         => $student,
					'education'        => $education,
                    'educationName'    => $educationName,
                    'idLang'           => $this->context->language->id,
					'studentEducation' => $studentEducation,
					'linkEval'         => $linkEval,
				]);

				$htmlContent = $tpl->fetch();
                fwrite($file,$htmlContent.PHP_EOL);
				$postfields = [
					'sender'      => [
						'name'  => sprintf($this->l("Administrative department of %s"), Configuration::get('EPH_SHOP_NAME')),
						'email' => Configuration::get('EPH_SHOP_EMAIL'),
					],
					'to'          => [
						[
							'name'  => $student->firstname . ' ' . $student->lastname,
							'email' => $student->email,
						],
					],
					'cc'          => [
						[
							'name'  => sprintf($this->l("Administrative department of %s"), Configuration::get('EPH_SHOP_NAME')),
							'email' => Configuration::get('EPH_SHOP_EMAIL'),
						],
					],
					'subject'     => sprintf($this->l('You have completed your training %s'), is_array($studentEducation->name) ? $studentEducation->name[$this->context->language->id] : $studentEducation->name),
					"htmlContent" => $htmlContent,
				];

				if ($student->id_gender == 1) {
					$meta_description = sprintf($this->l('Dear sir %s , your training %s just ended'), $student->firstname . ' ' . $student->lastname, is_array($studentEducation->name) ? $studentEducation->name[$this->context->language->id] : $studentEducation->name);
				} else {
					$meta_description = sprintf($this->l('Dear Madam %s , your training %s just ended'), $student->firstname . ' ' . $student->lastname, is_array($studentEducation->name) ? $studentEducation->name[$this->context->language->id] : $studentEducation->name);
				}
                fwrite($file,$meta_description.PHP_EOL);
				$result = Tools::sendEmail($postfields, $meta_description);

				$suivie = new StudentEducationSuivie();
				$suivie->suivie_date = date('Y-m-d');
				$suivie->id_student_education = $studentEducation->id;
				$suivie->email_title = sprintf($this->l('You have completed your training %s'), is_array($studentEducation->name) ? $studentEducation->name[$this->context->language->id] : $studentEducation->name);
				$suivie->content = sprintf($this->l('Training exit email for %s'), $student->firstname . ' ' . $student->lastname);
				$suivie->email_content = $htmlContent;
				$suivie->id_student_education_state = 8;
				$suivie->content = $step->suivie;
				$suivie->add();

			}

		}


	}

	public static function changeEducationStepId($idEducation, $idStep) {

		$context = Context::getContext();

		$step = new StudentEducationStep($idStep, $context->language->id);
		$education = new StudentEducation($idEducation);

		if ($education->id_student_education_state != $step->id) {

			if ($step->id == 4) {

				if (empty($education->reference_edof) || empty($education->identifiant) || empty($education->passwd_link)) {
					return;
				}

				$id_education_prerequis = $education->id_education_prerequis;

				if (!Validate::isUnsignedId($education->id_education_prerequis)) {

					if ($education->id_product_attribute > 0) {
						$id_education_prerequis = Db::getInstance()->getValue(
							(new DbQuery())
								->select('id_education_prerequis')
								->from('product_attribute')
								->where('id_product = ' . $education->id_product)
								->where('id_product_attribute = ' . $education->id_product_attribute)
						);
					} else {

						$id_education_prerequis = Db::getInstance()->getValue(
							(new DbQuery())
								->select('id_education_prerequis')
								->from('product')
								->where('id_product = ' . $education->id_product)
						);
					}

				}

				$prerequis = new EducationPrerequis($id_education_prerequis);
				$content = $prerequis->content;
				$score = 0;
				$result = [];

				if (is_array($content) && count($content)) {

					$nbQuestions = count($content);

					$delta = $nbQuestions - $prerequis->min_score;

					$match = $prerequis->min_score + rand(1, $delta);

					$rand_keys = array_rand($content, $match);

					foreach ($content as $key => $quesion) {

						if ($quesion['name'] == 'profession') {
							continue;
						}

						if (in_array($key, $rand_keys)) {
							$score = $score + 1;
							$result[$quesion['name']] = 1;
						} else {
							$result[$quesion['name']] = 0;
						}

					}

					$date_add = Db::getInstance()->getValue(
						(new DbQuery())
							->select('`date_add`')
							->from('student_education_suivie')
							->where('id_student_education = ' . $education->id)
							->where('id_student_education_state = 3')
					);

					$studentPrerequis = new StudentEducationPrerequis();
					$studentPrerequis->id_student_education = $education->id;
					$studentPrerequis->id_education_prerequis = $id_education_prerequis;
					$studentPrerequis->content = serialize($result);
					$studentPrerequis->score = $score;
					$studentPrerequis->date_add = $date_add;
					$studentPrerequis->add();
				}

			}

			$education->id_student_education_state = $step->id;
			$education->update();
            $emailContents = [];
			if ($step->send_email == 1) {
				$emailContents = StudentEducation::studentEmail($education->id, $step);
			}

			if ($step->send_agent_email == 1) {
				StudentEducation::sendCefEmail($education->id, $step);
			}
            $smsContent = '';
			if ($step->send_sms == 1) {
				$credits = Tool::getSendInBlueSmsCredit();
				

				if ($credits > 0) {
					$smsContent = $this->sendStudentSms($education->id, $step);
				}

			}

			if ($step->is_suivie == 1) {
				$suivie = new StudentEducationSuivie();
				$suivie->suivie_date = date('Y-m-d');
				$suivie->id_student_education = $education->id;
				$suivie->id_student_education_state = $step->id;
				$suivie->id_employee = $context->employee->id;

				if (is_array($emailContents) && count($emailContents)) {
					$suivie->email_title = $emailContents['email_title'];
					$suivie->email_content = $emailContents['email_content'];
				}

				if (is_array($smsContent) && count($smsContent)) {
					$suivie->email_title = $smsContent['sms_title'];
					$suivie->email_content = $smsContent['sms_content'];
				}

				$suivie->content = $step->suivie;
				$suivie->add();

			}

		}

		return true;
	}

	public static function sendStudentSms($idEducation, StudentEducationStep $step) {

		if (file_exists(_EPH_SMS_DIR_ . $step->sms_template . '.tpl')) {
			$context = Context::getContext();
			$studentEducation = new StudentEducation($idEducation, $context->language->id);
			$student = new User($studentEducation->id_user);

			$context->smarty->assign(
				[
					'student'          => $student,
					'studentEducation' => $studentEducation,
				]
			);

			$content = $context->smarty->fetch(_EPH_SMS_DIR_ . $step->sms_template . '.tpl');

			$recipient = $student->phone_mobile;
			Tool::sendSms($recipient, $content);
			return [
				'sms_title'   => $step->description,
				'sms_content' => $content,
			];
		}

	}

	public static function studentEmail($idEducation, StudentEducationStep $step) {

		$file = fopen("testSendStudentEmail.txt", "w");
		fwrite($file, "idEducation = " . $idEducation . PHP_EOL);

		fwrite($file, "idEducation = " . $idEducation . PHP_EOL);
		$context = Context::getContext();
		$studentEducation = new StudentEducation($idEducation, $context->language->id);
		fwrite($file, "idCertif = " . $studentEducation->id_certification . PHP_EOL);

		if ($step->id == 2 && $studentEducation->id_certification == 0) {
			fwrite($file, "Fait Chier" . PHP_EOL);
			$id_certification = Db::getInstance()->getValue(
				'SELECT id_certification FROM ' . _DB_PREFIX_ . 'student_education
                    WHERE id_student_education = ' . (int) $studentEducation->id
			);

			if ($id_certification > 0) {
				$studentEducation->id_certification = $id_certification;
				$studentEducation->reservationLink = $studentEducation->reservation_link;
			} else {
				return false;
			}

		}

		$customer = new User($studentEducation->id_user);
		$context = Context::getContext();

		if (!empty($step->template)) {

			$topic = $step->description;
			$education = new Product($studentEducation->id_product);
			$date_start = $studentEducation->date_start;
			$fileAttachement = null;

			$attachement = Db::getInstance(_EPH_USE_SQL_SLAVE_)->getValue(
				(new DbQuery())
					->select('fileName')
					->from('education_programme')
					->where('`id_product` = ' . (int) $studentEducation->id_product)
					->where('`id_product_attribute` = ' . (int) $studentEducation->id_product_attribute)
			);

			if ($attachement != '') {
				$fileName = _EPH_PROGRAM_DIR_ . $attachement;

				if (file_exists($fileName)) {
					$fileAttachement[] = [
						'content' => chunk_split(base64_encode(file_get_contents($fileName))),
						'name'    => $attachement,
					];
				}

			}

			$secret_iv = _COOKIE_KEY_;
			$secret_key = _PHP_ENCRYPTION_KEY_;
			$string = $customer->id . '-' . $customer->lastname . $customer->passwd;
			$crypto_key = Tools::encrypt_decrypt('encrypt', $string, $secret_key, $secret_iv);

			$linkPositionnement = Context::getContext()->link->getPageLink('index', true, Context::getContext()->language->id, ['crypto_key' => $crypto_key], false, 1) . '&submitPositionnement&idStudentEducation=' . $studentEducation->id;
			$tpl = $context->smarty->createTemplate(_EPH_MAIL_DIR_ . $step->template . '.tpl');
			$reservationLink = [];

			fwrite($file, print_r($studentEducation, true));
			$tpl->assign([
				'customer'           => $customer,
				'reservationLink'    => $reservationLink,
				'studentEducation'   => $studentEducation,
				'is_video_tuto'      => Configuration::get('EPH_ALLOW_VIDEO_TUTO'),
				'tutoVideo'          => Configuration::get('EPH_TUTO_VIDEO'),
				'referent'           => Configuration::get('EPH_HANDICAP_REFERENT'),
				'company'            => $context->company,
				'linkPositionnement' => $linkPositionnement,
			]);
			$email_content = $tpl->fetch();

			$postfields = [
				'sender'      => [
					'name'  => $context->employee->firstname . " de " . Configuration::get('EPH_SHOP_NAME'),
					'email' => $context->employee->email,
				],
				'to'          => [
					[
						'name'  => $customer->firstname . ' ' . $customer->lastname,
						'email' => $customer->email,
					],
				],

				'subject'     => $step->description,
				"htmlContent" => $email_content,
				'attachment'  => $fileAttachement,
			];

			$result = Tools::sendEmail($postfields);
			return [
				'email_title'   => $step->description,
				'email_content' => $email_content,
			];

		}

	}

	public static function sendCefEmail($idEducation, StudentEducationStep $step) {

		$studentEducation = new StudentEducation($idEducation);

		if ($studentEducation->id_sale_agent > 0) {
			$saleAgent = new SaleAgent($studentEducation->id_sale_agent);

			if ($saleAgent->sale_commission_amount == 0) {
				return;
			}
            $customer = new User($studentEducation->id_user);
            $context = Context::getContext();

            if (!empty($step->agent_template)) {
                $topic = $step->agent_description;
                $education = new Product($studentEducation->id_product);
                $date_start = $studentEducation->date_start;
                $fileAttachement = null;

                $tpl = $context->smarty->createTemplate(_EPH_MAIL_DIR_ . $step->agent_template . '.tpl');
                $tpl->assign([
				    'agent'            => $saleAgent,
				    'customer'         => $customer,
				    'studentEducation' => $studentEducation,
                ]);

                $postfields = [
                    'sender'      => [
					   'name'  => "Service  Administratif " . Configuration::get('EPH_SHOP_NAME'),
					   'email' => Configuration::get('EPH_SHOP_EMAIL'),
				    ],
				    'to'          => [
					   [
                          'name'  => $saleAgent->firstname . ' ' . $saleAgent->lastname,
						  'email' => $saleAgent->email,
					   ],
				    ],
                    'subject'     => $step->description,
				    "htmlContent" => $tpl->fetch(),
                ];
                $result = Tools::sendEmail($postfields);
                return [
				    'email_title'   => $step->description,
				    'email_content' => $tpl->fetch(),
                ];  
            }
		}
	}

	public static function getIdSessionbyOrganism($reference) {

		return Db::getInstance()->getValue(
			(new DbQuery())
				->select('id_student_education')
				->from('student_education')
				->where('`reference_organism` = ' . $reference)
				->where('`deleted` = 0')
		);

	}

	public static function proceedEducationAdjust() {

		$context = Context::getContext();

		$file = fopen("testproceedEducationAdjust.txt", "w");

		$today = date("Y-m-d");
		$date = new DateTime($today);
		$date->modify('-90 days');
		$dateEnd = $date->format('Y-m-d');

		$sessions = Db::getInstance()->executeS(
			(new DbQuery())

				->select('`id_education_session`')
				->from('education_session')
				->where('`session_date` < \'' . $dateEnd . '\'')
		);

		foreach ($sessions as $session) {
			$session = new EducationSession($session['id_education_session']);

			$educations = Db::getInstance()->executeS(
				(new DbQuery())
					->select('`id_student_education`')
					->from('student_education')
					->where('`id_education_session` = ' . $session->id)
					->where('`deleted` = 0')
					->where('id_student_education_state >= 4')
			);

			foreach ($educations as $education) {

				$percent = 0;
				$time = 0;

				$studentEducation = new StudentEducation($education['id_student_education']);
				$lenght = explode(":", $studentEducation->education_lenghts);
				$time = Tools::convertTimetoHex($lenght[0], $lenght[1]);
				$percent = round($time * 100 / $studentEducation->hours, 2);
				$min = $studentEducation->hours * 81.6 / 100;
				$max = $studentEducation->hours - 1;
				$target = round(rand($min, $max) + Tools::random_float(0, 1), 2);
				$compare = round($target * 100 / $studentEducation->hours, 2);

				if ((int) $compare > (int) $percent) {

					$timeToUpdate = Tools::convertTime($target);
					$studentEducation->education_lenghts = $timeToUpdate;
					$studentEducation->update(false, false);

				}

			}

		}
        
        //$this->compileArchive();

	}

	public function getEducationIndicateur() {

		$context = Context::getContext();

		$educations = Db::getInstance()->executeS(
			(new DbQuery())
				->select('e.id_product, e.reference, ea.id_product_attribute, ea.reference as refAttribute')
				->from('product', 'e')
				->leftJoin('product_attribute', 'ea', 'ea.id_product = e.id_product')
		);

		$result = [];

		foreach ($educations as $education) {

			$collection = [];

			if ($education["id_product_attribute"] > 0) {

				$studentEducations = Db::getInstance()->executeS(
					(new DbQuery())
						->select('id_student_education')
						->from('student_education')
						->where('id_product = ' . $education["id_product"])
						->where('id_product_attribute = ' . $education["id_product_attribute"])
						->where('id_student_education_state > 8 ')
						->where('id_student_education_state < 10 ')
				);

				foreach ($studentEducations as $studentEducation) {
					$collection[] = new StudentEducation($studentEducation['id_student_education'], $context->language->id);
				}

				$result[$education['refAttribute']] = $collection;

			} else {

				$studentEducations = Db::getInstance()->executeS(
					(new DbQuery())
						->select('id_student_education')
						->from('student_education')
						->where('id_product = ' . $education["id_product"])
						->where('id_student_education_state > 8 ')
						->where('id_student_education_state < 10 ')
				);

				foreach ($studentEducations as $studentEducation) {
					$collection[] = new StudentEducation($studentEducation['id_student_education'], $context->language->id);
				}

				$result[$education['reference']] = $collection;
			}

		}

		foreach ($result as $key => $values) {

			$answer = 0;
			$total = 0;
			$totalFormation = count($values);

			foreach ($values as $k => $value) {
				$id_education = $value->id_product;
				$id_education_attribute = $value->id_product_attribute;
				$name = $value->name;

				if ($value->answer_hot > 0) {
					$answer = $answer + 1;
					$total = $total + $value->score_hot;
				}

			}

			if ($answer > 0) {
				$average = $total / $answer;
				$note = ($average * 20 / 24);

				$idIndicateur = EducationIndicateur::getIdByeducation($id_education, $id_education_attribute);

				if ($idIndicateur > 0) {
					$indicateur = new EducationIndicateur($idIndicateur);
					$indicateur->score = $note;
					$indicateur->name = $name;
					$indicateur->qty = $totalFormation;
					$indicateur->update();
				} else {
					$indicateur = new EducationIndicateur();
					$indicateur->id_product = $id_education;
					$indicateur->id_product_attribute = $id_education_attribute;
					$indicateur->name = $name;
					$indicateur->score = $note;
					$indicateur->qty = $totalFormation;
					$indicateur->add();
				}

			}

		}

		return $result;

	}
    
	public static function getCommissionDueBySaleAgent(SaleAgent $saleAgent) {

		$today = date("Y-m-d");
            
        $datas = [];
        $grandTotal = 0;
        $grandTotalWTax = 0;

        $sessions = Db::getInstance(_EPH_USE_SQL_SLAVE_)->executeS(
            (new DbQuery())
            ->select('DISTINCT(se.id_education_session), es.name as sessionName')
            ->from('student_education', 'se')
			->leftJoin('education_session', 'es', 'es.`id_education_session` = se.`id_education_session`')
			->orderBy('es.`session_date` ')
			->where('se.id_sale_agent = ' . $saleAgent->id)
			->where('se.commission_due = 1')
			->where('se.commission_paid = 0')
			->where('es.`session_date` < \'' . $today . '\'')
			->orderBy('es.session_date ASC')
        );

        if (is_array($sessions) && count($sessions)) {

            foreach ($sessions as $session) {

                $commissions = Db::getInstance(_EPH_USE_SQL_SLAVE_)->executeS(
                    (new DbQuery())
					->select('se.id_student_education, CONCAT(s.`firstname`, \' \', s.`lastname`) AS `student`, es.name as sessionName, se.commission_amount as amount')
					->from('student_education', 'se')
					->leftJoin('education_session', 'es', 'es.`id_education_session` = se.`id_education_session`')
					->leftJoin('user', 's', 's.`id_user` = se.`id_user`')
					->orderBy('es.`session_date` ')
					->where('se.id_sale_agent = ' . $saleAgent->id)
					->where('es.id_education_session = ' . $session['id_education_session'])
					->where('se.commission_due = 1')
					->where('se.commission_paid = 0')
					->where('es.`session_date` < \'' . $today . '\'')
                );

                if (is_array($commissions) && count($commissions)) {
                    $totalDue = 0;
                    foreach ($commissions as &$commission) {
                        $totalDue = $totalDue + $commission['amount'];
                        if ($saleAgent->is_tax == 1) {
                            $commission['amount_wtax'] = round($commission['amount'] * 1.2, 2);
                        } else {
                            $commission['amount_wtax'] = $commission['amount'];
                        }
                    }

                }

                $grandTotal = $grandTotal + $totalDue;

                $datas[$session['sessionName']] = [
                    'totalDue'   => $totalDue,
					'educations' => $commissions,
				];
            }
            if ($saleAgent->is_tax == 1) {
                $grandTotalWTax = round($grandTotal * 1.2, 2);
            } else {
                $grandTotalWTax = $grandTotal;
            }

            $datas['grandTotal'] = $grandTotal;
            $datas['grandTotalWTax'] = $grandTotalWTax;
        }

        return $datas;
    }

	public static function printStudentAttestation($template, $ref, $header, $fileName, StudentEducation $studentEducation, Customer $student) {

		$context = Context::getContext();

		$idShop = $context->company->id;

		$pathLogo = StudentEducation::getLogo();
		$width = 0;
		$height = 0;

		if (!empty($pathLogo)) {
			list($width, $height) = getimagesize($pathLogo);
		}

		// Limit the height of the logo for the PDF render
		$maximumHeight = 150;

		if ($height > $maximumHeight) {
			$ratio = $maximumHeight / $height;
			$height *= $ratio;
			$width *= $ratio;
		}

		$mpdf = new \Mpdf\Mpdf([
			'margin_left'   => 10,
			'margin_right'  => 10,
			'margin_top'    => 80,
			'margin_bottom' => 30,
			'margin_header' => 10,
			'margin_footer' => 10,
		]);

		$data = $context->smarty->createTemplate(_EPH_PDF_DIR_ . 'attestations/' . $header . '.tpl');

		$data->assign(
			[

				'logo_path'   => $pathLogo,
				'width_logo'  => $width,
				'height_logo' => $height,
			]
		);
		$data->assign('logo_path', $logo_path);
		$mpdf->SetHTMLHeader($data->fetch());

		$data = $context->smarty->createTemplate(_EPH_PDF_DIR_ . 'attestations/footer.tpl');

		$data->assign(
			[
				'version'    => $ref,
				'tag_footer' => Configuration::get('EPH_FOOTER_PROGRAM'),
				'tags'       => Configuration::get('EPH_FOOTER_EMAIL'),
				'company'    => $context->company,
			]
		);
		$mpdf->SetHTMLFooter($data->fetch(), 'O');

		$data = $context->smarty->createTemplate(_EPH_PDF_DIR_ . 'pdf.css.tpl');
		$data->assign(
			[
				'color' => '#fff',
			]
		);
		$stylesheet = $data->fetch();

		$data = $context->smarty->createTemplate(_EPH_PDF_DIR_ . 'attestations/' . $template . '.tpl');

		$data->assign(
			[
				'title'            => $student->title,
				'student'          => $student,
				'studentEducation' => $studentEducation,
				'company'          => $context->company,
				'logo_tampon'      => _SHOP_ROOT_DIR_ . '/img/' . Configuration::get('EPH_SOURCE_STAMP'),
				'IpRfer'           => Tools::getRemoteAddr(),
			]
		);

		$filePath = _EPH_PDF_STUDENT_DIR_;

		$mpdf->SetTitle($template);
		$mpdf->SetAuthor('Groupe ' . Configuration::get('EPH_SHOP_NAME'));
		$mpdf->SetDisplayMode('fullpage');
		$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
		$mpdf->WriteHTML($data->fetch());
		$mpdf->Output($filePath . $fileName, 'F');

	}

	public static function getLogo() {

		$logo = '';
		$context = Context::getContext();

		if (Configuration::get('EPH_LOGO_INVOICE') != false && file_exists(_EPH_IMG_DIR_ . Configuration::get('EPH_LOGO_INVOICE'))) {
			$logo = $context->link->getBaseFrontLink() . 'img/' . Configuration::get('EPH_LOGO_INVOICE');
		} else

		if (Configuration::get('EPH_LOGO') != false && file_exists(_EPH_IMG_DIR_ . Configuration::get('EPH_LOGO'))) {
			$logo = $context->link->getBaseFrontLink() . 'img/' . Configuration::get('EPH_LOGO');
		}

		return $logo;
	}
    
    public function getNbStudent($idEducation) {

		$studentEducations = new PhenyxCollection('StudentEducation');
		$studentEducations->where('id_product', '=', $idEducation);

		return count($studentEducations);

	}

}
