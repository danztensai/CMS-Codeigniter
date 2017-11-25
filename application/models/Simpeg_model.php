<?php class Simpeg_model extends CI_Model {


		function __construct() {
			parent::__construct();

		}



		public function getRiwayatPangkat($nip)
		{
			  $DB2 =$this->load->database('simpegRef', TRUE);
				$querySQL = "SELECT rg.nip, rg.Golongan_idGolongan, rj.golNama, rg.jenisKP, rn.nnpang, rg.tmtGolongan, rg.nomorSk, rg.tanggalSk, rg.kpej, rp.npej
								FROM revReferenceSimpeg.golonganhistory rg
								INNER JOIN revReferenceSimpeg.jenisgolongan rj on rj.Golongan_id = rg.Golongan_idGolongan
								INNER JOIN revReferenceSimpeg.naikPangkat rn on rn.knpang = rg.jenisKP
								INNER JOIN revReferenceSimpeg.pejabatMenetapkan rp on rp.kpej = rg.kpej
								WHERE rg.nip = '$nip'
								ORDER BY rg.tmtGolongan ASC;";

				$data = array();
				$stackData = array();

				log_message('debug','getRiwayatPangkat: '.$querySQL);
				$query = $DB2->query($querySQL);

				if($query->num_rows()>0)
					{ $count = 1;
						foreach($query->result() as $row)
						{
							$data['nip']=$row->nip;
							$data['idGolongan']=$row->Golongan_idGolongan;
							$data['golNama']=$row->golNama;
							$data['jenisKP']=$row->jenisKP;
							$data['nnpang']=$row->nnpang;
							$data['tmtGolongan']=$row->tmtGolongan;
							$data['nomorSk']=$row->nomorSk;
							$data['tanggalSk']=$row->tanggalSk;
							$data['kpej']=$row->kpej;


						 array_push($stackData,$data);
						}
						$query->free_result();
						return $stackData;
					}else
					{

						$query->free_result();
						return $data;
					}
		}
		public function getTempatPegawai($nip)
		{
		$DB2 =$this->load->database('simpegRef', TRUE);
		$querySQL = "		 SELECT rw1.kwil as kwi1, rw1.nwil as nwil1, rw2.kwil AS kwil2, rw2.nwil as nwil2, rw3.kwil as kwil3,
		 rw3.nwil as nwil3, rw4.kwil as kwil4, rw4.nwil as nwil4, ru.kunker as kunker, ru.nunker as nunker, ru2.kunker as kunker2, ru2.nunker as nunker2
		FROM revReferenceSimpeg.jakhir rj
		LEFT JOIN revReferenceSimpeg.wilayah rw1 on rw1.kwil = CONCAT(SUBSTRING(rj.kwil, 1,2), '00000000')
		LEFT JOIN revReferenceSimpeg.wilayah rw2 on rw2.kwil = CONCAT(SUBSTRING(rj.kwil, 1,4), '000000')
		LEFT JOIN revReferenceSimpeg.wilayah rw3 on rw3.kwil = CONCAT(SUBSTRING(rj.kwil, 1,6), '0000')
		LEFT JOIN revReferenceSimpeg.wilayah rw4 on rw4.kwil = rj.kwil
		LEFT JOIN revReferenceSimpeg.unkerja2 ru on ru.kunker = CONCAT(SUBSTRING(rj.kunkers, 1,4), '00000000')
		LEFT JOIN revReferenceSimpeg.unkerja2 ru2 on ru2.kunker = CONCAT(SUBSTRING(rj.kunkers, 1,6), '000000')
		WHERE rj.NIP = '$nip'";

		$data = array();
		$stackData = array();

		log_message('debug','getTempatPegawai: '.$querySQL);
		$query = $DB2->query($querySQL);

		if($query->num_rows()>0)
			{ $count = 1;
				foreach($query->result() as $row)
				{
					$data['kwi1']=$row->kwi1;
					$data['nwil1']=$row->nwil1;
					$data['kwil2']=$row->kwil2;
					$data['nwil2']=$row->nwil2;
					$data['kwil3']=$row->kwil3;
					$data['nwil3']=$row->nwil3;
					$data['kwil4']=$row->kwil4;
					$data['nwil4']=$row->nwil4;
					$data['kunker']=$row->kunker;
					$data['nunker']=$row->nunker;
					$data['kunker2']=$row->kunker2;
					$data['nunker2']=$row->nunker2;
					//array_push($stackData,$data);
				}
				$query->free_result();
				return $data;
			}else
			{

				$query->free_result();
				return $data;
			}
		}

		public function getJabatanTerakhir($nip)
		{
		$DB2 =$this->load->database('simpegRef', TRUE);
		$querySQL = "SELECT rj.NIP as NIP, rj.KPEJ, rp.npej, rj.NSKJABAT, rj.TSKJABAT, rjn.namaJenisJabatan, rj.KESELON, rj.kunkers as kunker1,
		ru.nunker, ru2.nunker as nunker2, ru3.nunker as nunker3,
rj.KJAB, rjn.NJAB, rj.NJAB as njab2, rj.TLANTIK, rj.TMTJAB, rj.SJAB,rj.NLANTIK
FROM revReferenceSimpeg.jakhir rj
INNER JOIN revReferenceSimpeg.pejabatMenetapkan rp on rp.kpej = rj.KPEJ
INNER JOIN revReferenceSimpeg.jenisJabatan rjn on rjn.JNSJAB = rj.JNSJAB AND rjn.KJAB = rj.KJAB
INNER JOIN revReferenceSimpeg.unkerja ru on ru.kunker LIKE CONCAT(SUBSTRING(rj.kunkers, 1,8), '0000')
INNER JOIN revReferenceSimpeg.unkerja ru2 on ru2.kunker LIKE CONCAT(SUBSTRING(rj.kunkers, 1,10), '00')
INNER JOIN revReferenceSimpeg.unkerja ru3 on ru3.kunker = rj.kunkers
WHERE rj.NIP = '$nip'";

		$data = array();
		$stackData = array();

		log_message('debug','getJabatanTerakhir: '.$querySQL);
		$query = $DB2->query($querySQL);

		if($query->num_rows()>0)
			{ $count = 1;
				foreach($query->result() as $row)
				{
					$data['NIP']=$row->NIP;
					$data['KPEJ']=$row->KPEJ;
					$data['npej']=$row->npej;
					$data['NSKJABAT']=$row->NSKJABAT;
					$data['TSKJABAT']=$row->TSKJABAT;
					$data['namaJenisJabatan']=$row->namaJenisJabatan;
					$data['KESELON']=$row->KESELON;
					$data['kunker1']=$row->kunker1;
					$data['nunker']=$row->nunker;
					$data['nunker2']=$row->nunker2;
					$data['nunker3']=$row->nunker3;
					$data['KJAB']=$row->KJAB;
					$data['njab2']=$row->njab2;
					$data['TLANTIK']=$row->TLANTIK;
					$data['TMTJAB']=$row->TMTJAB;
					$data['SJAB']=$row->SJAB;
					$data['NLANTIK']=$row->NLANTIK;

					//array_push($stackData,$data);
				}
				$query->free_result();
				return $data;
			}else
			{

				$query->free_result();
				return $data;
			}
		}

		public function getGajiBerkala($nip)
		{
			  $DB2 =$this->load->database('simpegRef', TRUE);
				$querySQL = "SELECT NIP, NSTAHU, TSTAHU, TMTNGAJ, GPOKKHIR, k.KKANTOR, MSKERJA, FLAG,k.NKANTOR
				FROM gkkhir g left join kbayar k on g.KKANTOR=k.KKANTOR WHERE NIP = '$nip'";

				$data = array();
				$stackData = array();

				log_message('debug','getGajiBerkala: '.$querySQL);
				$query = $DB2->query($querySQL);

				if($query->num_rows()>0)
					{ $count = 1;
						foreach($query->result() as $row)
						{
							$data['NIP']=$row->NIP;
							$data['NSTAHU']=$row->NSTAHU;
							$data['TSTAHU']=$row->TSTAHU;
							$data['TMTNGAJ']=$row->TMTNGAJ;
							$data['GPOKKHIR']=$row->GPOKKHIR;
							$data['KKANTOR']=$row->KKANTOR;
							$data['NKANTOR']=$row->NKANTOR;
							$data['MSKERJA']=$row->MSKERJA;
							$data['FLAG']=$row->FLAG;


						 array_push($stackData,$data);
						}
						$query->free_result();
						return $stackData;
					}else
					{

						$query->free_result();
						return $data;
					}
		}


		public function getIdentitasPegawai($nip)
		{
			  $DB2 =$this->load->database('simpegRef', TRUE);
		$querySQL = "SELECT d.nipBaru, d.nipLama, d.nama, d.gelarDepan, d.gelarBlk,a.nama as agama, d.KTLAHIR, d.TLAHIR, d.KJKEL, d.agamaId,
d.jenisPegawai, c.statusCpnsPns, s.nStatusPegawai, d.kedudukanHukum, d.jenisKawin, d.KGOLDAR, d.alamat, d.ALRT,
d.ALRW, d.nomorTelpon, d.kwil, d.KPOS, d.kartuPegawai, d.taspen, d.askesNomor, d.NKARIS_SU, d.npwpNomor, d.NOPEN, d.FILE_BMP
FROM revReferenceSimpeg.datautama d
INNER JOIN revReferenceSimpeg.cpnspns c ON c.nipbaru = d.nipbaru
INNER JOIN revReferenceSimpeg.statusPegawai s on s.kStatusPegawai = c.statusCpnsPns
INNER JOIN revReferenceSimpeg.agama a on a.kode = d.agamaId WHERE d.nipbaru = '$nip'";

		$data = array();
		$stackData = array();

		log_message('debug','getIdentitasPegawai: '.$querySQL);
		$query = $DB2->query($querySQL);

		if($query->num_rows()>0)
			{ $count = 1;
				foreach($query->result() as $row)
				{
					$data['nipBaru']=$row->nipBaru;
					$data['nipLama']=$row->nipLama;
					$data['nama']=$row->nama;
					$data['gelarDepan']=$row->gelarDepan;
					$data['gelarBlk']=$row->gelarBlk;
					$data['agama']=$row->agama;
					$data['KTLAHIR']=$row->KTLAHIR;
					$data['TLAHIR']=$row->TLAHIR;
					$data['KJKEL']=$row->KJKEL;
					$data['jenisPegawai']=$row->jenisPegawai;
					$data['jenisKawin']=$row->jenisKawin;
					$data['KGOLDAR']=$row->KGOLDAR;
					$data['alamat']=$row->alamat;
					$data['ALRT']=$row->ALRT;
					$data['ALRW']=$row->ALRW;
					$data['noTelpon']=$row->nomorTelpon;
					$data['KPOS']=$row->KPOS;
					$data['kartuPegawai']=$row->kartuPegawai;
					$data['taspen']=$row->taspen;
					$data['askesNomor']=$row->askesNomor;
					$data['NKARIS_SU']=$row->NKARIS_SU;
					$data['npwpNomor']=$row->nama;
					$data['NOPEN']=$row->NOPEN;
					$data['FILE_BMP']=base_url().'assets/foto/'.$row->FILE_BMP;
					$data['agamaId']=$row->agamaId;
					$data['statusCpnsPns']=$row->statusCpnsPns;
					$data['kedudukanHukum']=$row->kedudukanHukum;

				//	array_push($stackData,$data);
				}
				$query->free_result();
				return $data;
			}else
			{

				$query->free_result();
				return $data;
			}
		}

		public function getCPNSPNSInfoByNip($nip)
		{
			  $DB2 =$this->load->database('simpegRef', TRUE);
		$querySQL = "SELECT nipBaru, nipLama, statusCpnsPns, NTBAKN, TNTBAKN, KPEJ_CPNS, nomorSkCpns, tglSkCpns, tmtCpns,
		 KGOLRU_CPNS, nomorSttpl, tglSttpl, tglSpmt, KPEJ_PNS,nomorSkPns, tglSkPns, tmtPns, KGOLRU_PNS, sumpahPNS
								FROM cpnspns WHERE nipBaru = '$nip'";

		$dataRet = array();
		$stackData = array();

		log_message('debug','getCPNSByNip	: '.$querySQL);
		$query = $DB2->query($querySQL);

		if($query->num_rows()>0)
			{ $count = 1;
				foreach($query->result() as $row)
				{
					$data = array();
					$data['nipBaru']=$row->nipBaru;
					$data['nipLama']=$row->nipLama;
					$data['statusCpnsPns']=$row->statusCpnsPns;
					$data['NTBAKN']=$row->NTBAKN;
					$data['TNTBAKN']=$row->TNTBAKN;
					$data['KPEJ_CPNS']=$row->KPEJ_CPNS;
					$data['nomorSkCpns']=$row->nomorSkCpns;
					$data['tglSkCpns']=$row->tglSkCpns;
					$data['tmtCpns']=$row->tmtCpns;
					$data['KGOLRU_CPNS']=$row->KGOLRU_CPNS;
					$data['nomorSttpl']=$row->nomorSttpl;
					$data['tglSttpl']=$row->tglSttpl;
					$data['KPEJ_PNS']=$row->KPEJ_PNS;
					$data['nomorSkPns']=$row->nomorSkPns;
					$data['tglSkPns']=$row->tglSkPns;
					$data['tmtPns']=$row->tmtPns;
					$data['KGOLRU_PNS']=$row->KGOLRU_PNS;
					$data['sumpahPNS']=$row->sumpahPNS;


					array_push($stackData,$data);
				}
				$query->free_result();
				return $stackData;
			}else
			{

				$query->free_result();
				return $dataRet;
			}
		}

		public function getPangkatAkhirByNip($nip)
		{
				$DB2 =$this->load->database('simpegRef', TRUE);
		$querySQL = "select * from golonganAkhir where nip='$nip';";

		$data = array();
		$stackData = array();

		log_message('debug','getPangkatAkhirByNip: '.$querySQL);
		$query = $DB2->query($querySQL);

		if($query->num_rows()>0)
			{ $count = 1;
				foreach($query->result() as $row)
				{
					$data['nip']=$row->nip;
					$data['KSTLUD']=$row->KSTLUD;
					$data['NSTLUD']=$row->NSTLUD;
					$data['TSTLUD']=$row->TSTLUD;
					$data['NNTBAKN']=$row->NNTBAKN;
					$data['TNTBAKN']=$row->TNTBAKN;
					$data['PTETAP']=$row->PTETAP;
					$data['NSKPANG']=$row->NSKPANG;
					$data['TSKPANG']=$row->TSKPANG;
					$data['TMTPANG']=$row->TMTPANG;
					$data['KGOLRU']=$row->KGOLRU;
					$data['MSKERJA']=$row->MSKERJA;
					$data['GPOK']=$row->GPOK;
					$data['KNPANG']=$row->KNPANG;

				//	array_push($stackData,$data);
				}
				$query->free_result();
				return $data;
			}else
			{

				$query->free_result();
				return $data;
			}
		}




		public function getRelationStatus()
		{
			  $DB2 =$this->load->database('simpegRef', TRUE);
		$querySQL = "SELECT * FROM statusperkawinan";

		$dataRet = array();
		$stackData = array();

		log_message('debug','getRelationStatus	: '.$querySQL);
		$query = $DB2->query($querySQL);

		if($query->num_rows()>0)
			{ $count = 1;
				foreach($query->result() as $row)
				{
					$data = array();
					$data['kode']=$row->kode;
					$data['nama']=$row->nama;

					array_push($stackData,$data);
				}
				$query->free_result();
				return $stackData;
			}else
			{

				$query->free_result();
				return $dataRet;
			}
		}

		public function getJenisNaikPangkat()
		{
			  $DB2 =$this->load->database('simpegRef', TRUE);
		$querySQL = "SELECT * FROM naikPangkat";

		$dataRet = array();
		$stackData = array();

		log_message('debug','getRelationStatus	: '.$querySQL);
		$query = $DB2->query($querySQL);

		if($query->num_rows()>0)
			{ $count = 1;
				foreach($query->result() as $row)
				{
					$data = array();
					$data['kode']=$row->knpang;
					$data['nama']=$row->nnpang;

					array_push($stackData,$data);
				}
				$query->free_result();
				return $stackData;
			}else
			{

				$query->free_result();
				return $dataRet;
			}
		}

		public function getStlud()
		{
			  $DB2 =$this->load->database('simpegRef', TRUE);
		$querySQL = "SELECT * FROM stlud";

		$dataRet = array();
		$stackData = array();

		log_message('debug','getRelationStatus	: '.$querySQL);
		$query = $DB2->query($querySQL);

		if($query->num_rows()>0)
			{ $count = 1;
				foreach($query->result() as $row)
				{
					$data = array();
					$data['kode']=$row->KSTLUD;
					$data['nama']=$row->NSTLUD;

					array_push($stackData,$data);
				}
				$query->free_result();
				return $stackData;
			}else
			{

				$query->free_result();
				return $dataRet;
			}
		}

		public function getJenisGolongan()
		{
			  $DB2 =$this->load->database('simpegRef', TRUE);
		$querySQL = "SELECT * FROM jenisgolongan";

		$dataRet = array();
		$stackData = array();

		log_message('debug','getRelationStatus	: '.$querySQL);
		$query = $DB2->query($querySQL);

		if($query->num_rows()>0)
			{ $count = 1;
				foreach($query->result() as $row)
				{
					$data = array();
					$data['kode']=$row->Golongan_id;
					$data['nama']=$row->golNama;
					$data['pangkat']=$row->golPangkat;

					array_push($stackData,$data);
				}
				$query->free_result();
				return $stackData;
			}else
			{

				$query->free_result();
				return $dataRet;
			}
		}

		public function getJenisPegawai()
		{
			  $DB2 =$this->load->database('simpegRef', TRUE);
		$querySQL = "SELECT * FROM jenispegawai";

		$dataRet = array();
		$stackData = array();

		log_message('debug','getJenisPegawai	: '.$querySQL);
		$query = $DB2->query($querySQL);

		if($query->num_rows()>0)
			{ $count = 1;
				foreach($query->result() as $row)
				{
					$data = array();
					$data['kode']=$row->kode;
					$data['nama']=$row->nama;

					array_push($stackData,$data);
				}
				$query->free_result();
				return $stackData;
			}else
			{

				$query->free_result();
				return $dataRet;
			}
		}

		public function getJenisPejabatMenetapkan()
		{
				$DB2 =$this->load->database('simpegRef', TRUE);
		$querySQL = "SELECT * FROM pejabatmenetapkan";

		$dataRet = array();
		$stackData = array();

		log_message('debug','getJenisPejabatMenetapkan	: '.$querySQL);
		$query = $DB2->query($querySQL);

		if($query->num_rows()>0)
			{ $count = 1;
				foreach($query->result() as $row)
				{
					$data = array();
					$data['kode']=$row->kpej;
					$data['nama']=$row->npej;

					array_push($stackData,$data);
				}
				$query->free_result();
				return $stackData;
			}else
			{

				$query->free_result();
				return $dataRet;
			}
		}

		public function getStatusPegawai()
		{
			  $DB2 =$this->load->database('simpegRef', TRUE);
		$querySQL = "SELECT * FROM statuspegawai";

		$dataRet = array();
		$stackData = array();

		log_message('debug','getStatusPegawai	: '.$querySQL);
		$query = $DB2->query($querySQL);

		if($query->num_rows()>0)
			{ $count = 1;
				foreach($query->result() as $row)
				{
					$data = array();
					$data['kode']=$row->kStatusPegawai;
					$data['nama']=$row->nStatusPegawai;

					array_push($stackData,$data);
				}
				$query->free_result();
				return $stackData;
			}else
			{

				$query->free_result();
				return $dataRet;
			}
		}

		public function getKedudukanPegawai()
		{
			  $DB2 =$this->load->database('simpegRef', TRUE);
		$querySQL = "SELECT * FROM kedudukanpegawai";

		$dataRet = array();
		$stackData = array();

		log_message('debug','getKedudukanPegawai	: '.$querySQL);
		$query = $DB2->query($querySQL);

		if($query->num_rows()>0)
			{ $count = 1;
				foreach($query->result() as $row)
				{
					$data = array();
					$data['kode']=$row->id;
					$data['nama']=$row->nama;

					array_push($stackData,$data);
				}
				$query->free_result();
				return $stackData;
			}else
			{

				$query->free_result();
				return $dataRet;
			}
		}

		public function getAgama()
		{
			  $DB2 =$this->load->database('simpegRef', TRUE);
		$querySQL = "SELECT * FROM agama";

		$dataRet = array();
		$stackData = array();

		log_message('debug','getAgama	: '.$querySQL);
		$query = $DB2->query($querySQL);

		if($query->num_rows()>0)
			{ $count = 1;
				foreach($query->result() as $row)
				{
					$data = array();
					$data['kode']=$row->kode;
					$data['nama']=$row->nama;

					array_push($stackData,$data);
				}
				$query->free_result();
				return $stackData;
			}else
			{

				$query->free_result();
				return $dataRet;
			}
		}
		public function getJenisKelamin()
		{
			  $DB2 =$this->load->database('simpegRef', TRUE);
		$querySQL = "SELECT * FROM jeniskelamin";

		$data = array();
		$stackData = array();

		log_message('debug','getJenisKelamin	: '.$querySQL);
		$query = $DB2->query($querySQL);

		if($query->num_rows()>0)
			{ $count = 1;
				foreach($query->result() as $row)
				{
					$data['KJKEL']=$row->KJKEL;
					$data['NKELAMIN']=$row->NKELAMIN;

					array_push($stackData,$data);
				}
				$query->free_result();
				return $stackData;
			}else
			{

				$query->free_result();
				return $data;
			}
		}

    public function getCountTotalRowCurrentBirthday($key,$limitStart,$limitLength,$searchColumn,$draw,$orderByColumn,$orderByDir)
    {
    $DB2 =$this->load->database('simpegRef', TRUE);

    $querySqlCount = "select count(*) as total
                  from datautama du
                  left join jakhir ja on du.nipBaru = ja.nip
                  left join unkerja k1 on k1.kunker = ja.kunkers
                  left join unkerja k2 on k2.kunker = ja.kunkersInduk
                  where du.kedudukanHukum=1 and du.statusHidupPensiunPindah =1  and ja.jnsjab=1 and MONTH(STR_TO_DATE(DU.TLAHIR, '%Y-%m-%d')) = MONTH(NOW()) and day(STR_TO_DATE(DU.TLAHIR, '%Y-%m-%d')) = day(NOW()) and
                  du.nama like '%$searchColumn%' ";


      log_message('debug','Query TotalCountRow GetPegawaiUmum :'.$querySqlCount);
      $query = $DB2->query($querySqlCount);

      $total=0;
      if($query->num_rows()>0)
        { $count = 1;
          foreach($query->result() as $row)
          {
            $total=$row->total;


          }
          $query->free_result();


        }
        return $total;
    }

    function getCurentDayBirthDay ($key,$limitStart,$limitLength,$searchColumn,$draw,$orderByColumn,$orderByDir)
    {
      $orderBy = $orderByColumn;
      $orderQuery = '';
      if($orderByColumn != 0)
			{
				log_message('debug','Inside Order By 0');
				$orderQuery = "order by ".($orderByColumn+1)." ".$orderByDir;


			}
      $querySQL = "select du.nipBaru as nip,du.nama as nama,k2.nunker as instansi,k1.nunker as subUnit ,ja.NJAB as jabatan,DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(DU.TLAHIR)), '%Y')+0 AS age
                    from datautama du
                    left join jakhir ja on du.nipBaru = ja.nip
                    left join unkerja k1 on k1.kunker = ja.kunkers
                    left join unkerja k2 on k2.kunker = ja.kunkersInduk
                    where du.kedudukanHukum=1 and du.statusHidupPensiunPindah =1  and MONTH(STR_TO_DATE(DU.TLAHIR, '%Y-%m-%d')) = MONTH(NOW()) and day(STR_TO_DATE(DU.TLAHIR, '%Y-%m-%d')) = day(NOW()) and ja.jnsjab=1 and
                    du.nama like '%$searchColumn%' ".$orderQuery." limit $limitStart,$limitLength";
      $DB2 =$this->load->database('simpegRef', TRUE);
      log_message('debug','Query getCurrentBirthday :  '.$querySQL);

      $stackData = array();
      $query = $DB2->query($querySQL);

      if($query->num_rows()>0)
        { $count = 1;
          foreach($query->result() as $row)
          {
            $data = array();
            $data[]=$row->nip;
            $data[]=$row->nama;
            $data[]=$row->age;
            $data[]=$row->instansi;
            $data[]=$row->subUnit;
            $data[]=$row->jabatan;


            array_push($stackData,$data);
          }
          $query->free_result();
          return $stackData;
        }else
        {

          $query->free_result();
          return null;
        }
    }

}
