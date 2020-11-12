<?php

class InfoJobs {

    private $base;
    private $username;
    private $password;
    private $email;
    private $token;

    public function __construct($params){

        // Credenziali
        $this->base     = (string)$params['credentials']['base'];
        $this->username = (string)$params['credentials']['username'];
        $this->password = (string)$params['credentials']['password'];
        $this->email    = (string)$params['credentials']['email'];

        // Opzioni
        $this->json     = (boolean)$params['json']      ? true : false;
        $this->compact  = (boolean)$params['compact']   ? true : false;

    }

    public function buildXml(){

        $this->xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" '.$this->schema.'>
					<soapenv:Header>
						<wsse:Security soapenv:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
				            <wsse:UsernameToken wsu:Id="UsernameToken-799830164" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
				                <wsse:Username>'.$this->username.'</wsse:Username>
				                <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">'.$this->password.'</wsse:Password>
				            </wsse:UsernameToken>
				        </wsse:Security>';

        if($this->token){
            $this->xml .= '<ij:authnHeader xmlns:ij="http://api.infojobs.net/soap/authn"><token>'.$this->token.'</token></ij:authnHeader>';
        }

        $this->xml .= '</soapenv:Header>';
        
        $this->xml .= '<soapenv:Body>';
        $this->xml .= $this->body;
        $this->xml .= '</soapenv:Body>';
        $this->xml .= '</soapenv:Envelope>';

        return trim(str_replace(["\n","\r","\t"],'', $this->xml ));

    }

    public function setService($params = null){

        switch($this->action){
            case 'findByListName':
                $this->schema = 'xmlns:lis="http://listOfValues.service.ws.infojobs.net/"';
                $this->service = 'WSListOfValuesService';
                $this->body = '<lis:findByListName><publicNameKey>'.$params['key'].'</publicNameKey></lis:findByListName>';
            break;

            case 'findByListNameAndParentId':
                $this->schema = 'xmlns:lis="http://listOfValues.service.ws.infojobs.net/"';
                $this->service = 'WSListOfValuesService';
                $this->body = '<lis:findByListNameAndParentId>
                                    <publicNameKey>'.$params['key'].'</publicNameKey>
                                    <parentId>'.$params['parent'].'</parentId>
                                </lis:findByListNameAndParentId>';
            break;

            case 'getAccessToken' :
                $this->schema = 'xmlns:acc="http://accesstoken.endpoints.www.soap.infojobs.net/"';
                $this->service = 'WSAccessTokenService';
                $this->body = ' <acc:getAccessToken>
                                    <email>'.$this->email.'</email>
                                </acc:getAccessToken>';
            break;

            case 'findMyProfiles' :
                $this->schema = 'xmlns:off="http://offer.endpoints.www.soap.infojobs.net/"';
                $this->service = 'WSOfferV3Service';
                $this->body = '<off:findMyProfiles/>';
            break;

            case 'findMyUpsellings' :
                $this->schema = 'xmlns:off="http://offer.endpoints.www.soap.infojobs.net/"';
                $this->service = 'WSOfferService';
                $this->body = '<off:findMyUpsellings/>';
            break;

            case 'findOffers' :
                $this->schema = 'xmlns:off="http://offerV3.endpoints.www.soap.infojobs.net/"';
                $this->service = 'WSOfferV3Service';
                $this->body = '<off:findOffersPublishedByEmployer/>';
            break;

            case 'createOffer' :
                $this->schema = 'xmlns:off="http://offer.endpoints.www.soap.infojobs.net/"';
                $this->service = 'WSOfferV3Service';
                $this->body = '<off:createOffer><wsCreateOfferRequestBean>';

                if( $this->hasParam('title',$params))               $this->body .= '<jobTitle>'.$params['title'].'</jobTitle>';
                if( $this->hasParam('description',$params))         $this->body .= '<jobDescription>'.$params['description'].'</jobDescription>';
                if( $this->hasParam('level',$params))               $this->body .= '<levelId>'.$params['level'].'</levelId>';
                if( $this->hasParam('country',$params))             $this->body .= '<countryId>'.$params['country'].'</countryId>';
                if( $this->hasParam('province',$params))            $this->body .= '<provinceId>'.$params['province'].'</provinceId>';
                if( $this->hasParam('city',$params))                $this->body .= '<city>'.$params['city'].'</city>';
                if( $this->hasParam('cap',$params))                 $this->body .= '<zip>'.$params['cap'].'</zip>';
                if( $this->hasParam('industry',$params))            $this->body .= '<jobIndustryId>'.$params['industry'].'</jobIndustryId>';
                if( $this->hasParam('subindustry',$params))         $this->body .= '<jobSubindustryId>'.$params['subindustry'].'</jobSubindustryId>';
                if( $this->hasParam('studies',$params))             $this->body .= '<minimumStudiesId>'.$params['studies'].'</minimumStudiesId>';
                if( $this->hasParam('experience',$params))          $this->body .= '<minimumExperienceId>'.$params['experience'].'</minimumExperienceId>';
                if( $this->hasParam('vacancies',$params))           $this->body .= '<numberOfVacancies>'.$params['vacancies'].'</numberOfVacancies>';
                if( $this->hasParam('contractType',$params))        $this->body .= '<contractTypeId>'.$params['contractType'].'</contractTypeId>';
                if( $this->hasParam('workingDay',$params))          $this->body .= '<workingDayId>'.$params['workingDay'].'</workingDayId>';
                if( $this->hasParam('salaryPer',$params))           $this->body .= '<salaryPerId>'.$params['salaryPer'].'</salaryPerId>';
                if( $this->hasParam('salaryFrom',$params))          $this->body .= '<salaryFromId>'.$params['salaryFrom'].'</salaryFromId>';
                if( $this->hasParam('salaryTo',$params))            $this->body .= '<salaryToId>'.$params['salaryTo'].'</salaryToId>';
                 
                 
                if( $this->hasParam('department',$params))          $this->body .= '<department>'.$params['department'].'</department>';
                if( $this->hasParam('staff',$params))               $this->body .= '<staffInChargeId>'.$params['staff'].'</staffInChargeId>';
                if( $this->hasParam('speciality',$params))          $this->body .= '<specialityId>'.$params['speciality'].'</specialityId>';
                if( $this->hasParam('residenceIn',$params))         $this->body .= '<residenceInId>'.$params['residenceIn'].'</residenceInId>';
                if( $this->hasParam('requiredSkills',$params))      $this->body .= '<requiredJobSkills>'.$params['requiredSkills'].'</requiredJobSkills>';
                if( $this->hasParam('desiredJobSkills',$params))    $this->body .= '<desiredJobSkills>'.$params['desiredJobSkills'].'</desiredJobSkills>';
                if( $this->hasParam('nationlity',$params))          $this->body .= '<nationalityId>'.$params['nationlity'].'</nationalityId>';
                if( $this->hasParam('jobDuration',$params))         $this->body .= '<jobDuration>'.$params['jobDuration'].'</jobDuration>';
                if( $this->hasParam('timetable',$params))           $this->body .= '<timetable>'.$params['timetable'].'</timetable>';
                if( $this->hasParam('salaryBenefits',$params))      $this->body .= '<salaryBenefits>'.$params['salaryBenefits'].'</salaryBenefits>';
                if( $this->hasParam('studying',$params))            $this->body .= '<studying>true</studying>';
                if( $this->hasParam('hide_salary',$params))         $this->body .= '<hideSalary>'.$params['hide_salary'].'</hideSalary>';
                if( $this->hasParam('email',$params))               $this->body .= '<emailFeedbackInsc>'.$params['email'].'</emailFeedbackInsc>';
                if( $this->hasParam('publication',$params))         $this->body .= '<publicationId>'.$params['publication'].'</publicationId>';
                if( $this->hasParam('url',$params))                 $this->body .= '<urlExternalApplication>'.$params['url'].'</urlExternalApplication>';
                if( $this->hasParam('skills',$params)){
                    $this->body .= '<knowledgeList>';
                    foreach($params['skills'] as $skill){
                        if($skill) $this->body .= '<knowledge><name>'.$skill.'</name></knowledge>';
                    }
                    $this->body .= '</knowledgeList>';
                }
                
                $this->body .=  '</wsCreateOfferRequestBean></off:createOffer>';

            break;

            case 'editOffer' :

                $this->schema = 'xmlns:off="http://offer.endpoints.www.soap.infojobs.net/"';
                $this->service = 'WSOfferV3Service';
                $this->body = '<off:editOffer><wsEditOfferRequestBean>';
            
                /** 
                 * Required 
                 * */
                if( $this->hasParam('offerCode',$params))           $this->body .= '<code>'.$params['offerCode'].'</code>';
                if( $this->hasParam('city',$params))                $this->body .= '<city>'.$params['city'].'</city>';
                if( $this->hasParam('cap',$params))                 $this->body .= '<zip>'.$params['cap'].'</zip>';
                if( $this->hasParam('contractType',$params))        $this->body .= '<contractTypeId>'.$params['contractType'].'</contractTypeId>';
                if( $this->hasParam('description',$params))         $this->body .= '<jobDescription>'.$params['description'].'</jobDescription>';
                if( $this->hasParam('subindustry',$params))         $this->body .= '<jobSubindustryId>'.$params['subindustry'].'</jobSubindustryId>';
                if( $this->hasParam('level',$params))               $this->body .= '<levelId>'.$params['level'].'</levelId>';
                if( $this->hasParam('experience',$params))          $this->body .= '<minimumExperienceId>'.$params['experience'].'</minimumExperienceId>';
                if( $this->hasParam('studies',$params))             $this->body .= '<minimumStudiesId>'.$params['studies'].'</minimumStudiesId>';
                if( $this->hasParam('workingDay',$params))          $this->body .= '<workingDayId>'.$params['working_day'].'</workingDayId>';
                if( $this->hasParam('salaryPer',$params))           $this->body .= '<salaryPerId>'.$params['salaryPer'].'</salaryPerId>';
                if( $this->hasParam('salaryFrom',$params))          $this->body .= '<salaryFromId>'.$params['salaryFrom'].'</salaryFromId>';
                if( $this->hasParam('salaryPo',$params))            $this->body .= '<salaryToId>'.$params['salaryTo'].'</salaryToId>';
                if( $this->hasParam('vacancies',$params))           $this->body .= '<numberOfVacancies>'.$params['vacancies'].'</numberOfVacancies>';

                /** 
                 * Optional 
                 * */
                if( $this->hasParam('department',$params))          $this->body .= '<department>'.$params['department'].'</department>';
                if( $this->hasParam('desiredJobSkills',$params))    $this->body .= '<desiredJobSkills>'.$params['desiredJobSkills'].'</desiredJobSkills>';
                if( $this->hasParam('requiredSkills',$params))      $this->body .= '<requiredJobSkills>'.$params['requiredSkills'].'</requiredJobSkills>';
                if( $this->hasParam('email',$params))               $this->body .= '<emailFeedbackInsc>'.$params['email'].'</emailFeedbackInsc>';
                if( $this->hasParam('jobDuration',$params))         $this->body .= '<jobDuration>'.$params['jobDuration'].'</jobDuration>';
                if( $this->hasParam('staff',$params))               $this->body .= '<staffInChargeId>'.$params['staff'].'</staffInChargeId>';
                if( $this->hasParam('nationality',$params))         $this->body .= '<nationalityId>'.$params['nationality'].'</nationalityId>';
                if( $this->hasParam('residenceIn',$params))         $this->body .= '<residenceInId>'.$params['residenceIn'].'</residenceInId>';
                if( $this->hasParam('salaryBenefits',$params))      $this->body .= '<salaryBenefits>'.$params['salaryBenefits'].'</salaryBenefits>';
                if( $this->hasParam('speciality',$params))          $this->body .= '<specialityId>'.$params['speciality'].'</specialityId>';
                if( $this->hasParam('studying',$params))            $this->body .= '<studying>'.$params['studying'].'</studying>';
                if( $this->hasParam('timetable',$params))           $this->body .= '<timetable>'.$params['timetable'].'</timetable>';
                if( $this->hasParam('url',$params))                 $this->body .= '<urlExternalApplication>'.$params['url'].'</urlExternalApplication>';
                if( $this->hasParam('hideSalary',$params))          $this->body .= '<hideSalary>'.$params['hideSalary'].'</hideSalary>';
                if( $this->hasParam('skills',$params)){
                    $this->body .= '<knowledgeList>';
                    foreach($params['skills'] as $skill){
                        $this->body .= '<knowledge><name>'.$skill.'</name></knowledge>';
                    }
                    $this->body .= '</knowledgeList>';
                }

                $this->body .= '</wsEditOfferRequestBean></off:editOffer>';

            break;

            case 'disableOffer' :
                $this->schema = 'xmlns:off="http://offer.endpoints.www.soap.infojobs.net/"';
                $this->service = 'WSOfferV3Service';
                $this->body = '<off:disableOffer><offerCode>'.$params['offerCode'].'</offerCode></off:disableOffer>';
            break;

            case 'enableOffer' :
                $this->schema = 'xmlns:off="http://offer.endpoints.www.soap.infojobs.net/"';
                $this->service = 'WSOfferV3Service';
                $this->body = '<off:enableOffer><offerCode>'.$params['offerCode'].'</offerCode></off:enableOffer>';
            break;
            
            case 'eraseOffer' :
                $this->schema = 'xmlns:off="http://offer.endpoints.www.soap.infojobs.net/"';
                $this->service = 'WSOfferV3Service';
                $this->body = '<off:eraseOffer><offerCode>'.$params['offerCode'].'</offerCode></off:eraseOffer>';
            break;

        }
    }

    public function get(){

        $url = $this->base.$this->service;

        $curl = curl_init();

        curl_setopt_array($curl,[
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $this->xml,
        ]);
    
        $response = curl_exec($curl);
        $err = curl_error($curl);
    
        curl_close($curl);
    
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            $response = str_replace(['ns1:', 'soap:'], '', $response);
            $response = simplexml_load_string($response);
            return $this->data = $response->Body;
        }

    }

    public function parse(){

        /**
         * Gestione degli errore
         */
        if($this->data->Fault){
            $this->data = [
                'error' => true,
                'body' => [
                    'code' => (string)$this->data->Fault->faultcode,
                    'message' => (string)$this->data->Fault->faultstring
                ]
            ];

            if($this->compact){
                $this->data = $this->data['body'];
            }
    
            if($this->data) {
                return $this->json ? json_encode($this->data,JSON_UNESCAPED_SLASHES) : $this->data;
            }
        }
        
        /**
         * In base all'action, gestisco l'output della response
         */
        switch($this->action) {

            case 'getAccessToken' :
                $this->data = (string)$this->data->getAccessTokenResponse->token;
                $this->token = $this->data;
            break;
  
            case 'findMyProfiles' :
                $response = $this->data->findMyProfilesResponse->profileList->profile;
                $this->data = [
                    'error' => false,
                    'body'  => [
                        'blind' => (string)$response->blind,
                        'code'  => (string)$response->code,
                        'name'  => (string)$response->name
                    ]
                ];
            break;

            case 'findOffers' :
                $response = (array)$this->data->findOffersPublishedByEmployerResponse->offerList;
                $this->data = [
                    'error' => false,
                    'body'  => []
                ];
                foreach($response as $items){
                    foreach($items as $item){
                        array_push($this->data['body'],[
                            'name'      => (string)$item->name,
                            'offerCode' => (string)$item->offerCode,
                            'status'    => (string)$item->status
                        ]);
                    }
                }
            break;

            case 'findByListName' :
            case 'findByListNameAndParentId' :
                $response = $this->data->{$this->action.'Response'}->listOfValues->items;
                $this->data = [
                    'error' => false,
                    'body'  => []
                ];
                foreach($response as $item){
                    array_push($this->data['body'],[
                        'id' => (string)$item->id,
                        'label' => (string)$item->valor
                    ]);
                }
            break;

            case 'editOffer' :
                $response = (string)$this->data->editOfferResponse->wsEditOfferResponseBean->offerCode;
                $this->data = [
                    'error' => false,
                    'body'  => [
                        'offerCode' => $response
                    ]
                ];
            break;

            case 'createOffer' :
                $response = $this->data->createOfferResponse->wsCreateOfferResponseBean;
                $this->data = [
                    'error' => false,
                    'body'  => [
                        'title'  => (string)$response->jobTitle,
                        'offerCode' => (string)$response->offerCode,
                        'industry' => (string)$response->jobIndustryId,
                        'province' => (string)$response->provinceId
                    ]
                ];
            break;

            case 'enableOffer' :
            case 'disableOffer' :
            
                $response = (string)$this->data->{$this->action.'Response'}->offerSummary->offerCode;
                $this->data = [
                    'error' => false,
                    'body' => [
                        'offerCode' => $response
                    ]
                ];
            break;

            case 'eraseOffer' :
                $response = (string)$this->data->eraseOfferResponse->eraseResult;
                $this->data = [
                    'error' => false,
                    'body' => [
                        'erase' => $response
                    ]
                ];
            break;

        }
        
        if($this->compact){
            $this->data = $this->data['body'];
        }

        if($this->data) {
            return $this->json ? json_encode($this->data,JSON_UNESCAPED_SLASHES) : $this->data;
        }
    }

    public function hasParam($param,$array){
        return (array_key_exists($param,$array) && $array[$param]);
    }

    public function debug(){
        var_dump([
            'token' => $this->token,
            'xml' => $this->xml
        ]);
    }

    public function request($action,$params = null){

        $this->action = $action;
        $this->setService($params);
        $this->buildXml();
        $this->data = $this->get();
        
        return $this->parse();
    }

    public function acceptedAction($action){
        return in_array($action,[
            'eraseOffer',
            'disableOffer',
            'enableOffer',
            'editOffer',
            'findByListNameAndParentId',
            'findByListName',
            'findOffers',
            'findMyProfiles',
            'getAccessToken',
            'createOffer',
            'editOffer',
        ]);
    }

    public function __call($method, $arguments) {
        if($this->acceptedAction($method)) {
            return $this->request($method,$arguments[0]);
        } else {
            return [
                'error' => true,
                'body' => 'Action not exist'
            ];
        }
    }


    /**
     * ALIAS
     */

    // Categorie
    public function getCategories(){
        return $this->findByListName(['key'=>'CATEGORIES']);
    }
    // Settori
    public function getSubCategories($id){
        return $this->findByListNameAndParentId(['key'=>'SUBCATEGORIES','parent'=>$id]);
    }

    // Elenco industrie
    public function getIndustries(){
        return $this->findByListName(['key'=>'INDUSTRIES']);
    }

    // Tipo di contratto
    public function getContracts(){
        return $this->findByListName(['key'=>'CONTRACTS']);
    }
    
    // Regioni
    public function getComunities(){
        return $this->findByListName(['key'=>'COMUNITIES']);
    }
    // Paesi
    public function getCountries(){
        return $this->findByListName(['key'=>'COUNTRIES']);
    }

    // Province
    public function getProvinces($id){
        return $this->findByListNameAndParentId(['key'=>'PROVINCES','parent'=>$id]);
    }

    // Impegno lavorativo
    public function getWorkingDays(){
        return $this->findByListName(['key'=>'DAYS']);
    }

    // Propensione al cambiamento della posizione lavorativa
    public function getDisponibilities(){
        return $this->findByListName(['key'=>'DISPONIBILITIES']);
    }

    // Propensione al cambiamento della posizione lavorativa
    public function getDriveLicense(){
        return $this->findByListName(['key'=>'DRIVINGLICENCES']);
    }

    // Elenco lingue
    public function getLanguages(){
        return $this->findByListName(['key'=>'LANGUAGES']);
    }

    // Livello impiegatizzo
    public function getLaborLevel(){
        return $this->findByListName(['key'=>'LABORALLEVEL']);
    }

    // Livello minimo di esperienza
    public function getMinExperience(){
        return $this->findByListName(['key'=>'MINEXPERIENCES']);
    }

    // Livello minimo di esperienza
    public function getVacancies(){
        return $this->findByListName(['key'=>'PERSONNELTOPOSITION']);
    }

   
    // Residenza
    public function getResidents(){
        return $this->findByListName(['key'=>'RESIDENTS']);
    }

    // Genere
    public function getSex(){
        return $this->findByListName(['key'=>'SEXS']);
    }

    // Livello per la skill
    public function getSkillLevel(){
        return $this->findByListName(['key'=>'SKILLLEVEL']);
    }

    // Studi
    public function getStudiesLevel(){
        return $this->findByListName(['key'=>'STUDIESLEVEL']);
    }
    public function getSubStudies($id){
        return $this->findByListNameAndParentId(['key'=>'DETAILSTUDIES','parent'=>$id]);
    }

    // Livello lingua lettura
    public function getReadLevel(){
        return $this->findByListName(['key'=>'READLEVEL']);
    }
    
    // Livello lingua parlata
    public function getSpokenLevel(){
        return $this->findByListName(['key'=>'SPOKENLEVEL']);
    }

    // Livello lingua scritta
    public function getWrittenLevel(){
        return $this->findByListName(['key'=>'WRITTENLEVEL']);
    }

    // Tipo url
    public function getUrlType(){
        return $this->findByListName(['key'=>'URLTYPE']);
    }
    

    // Tariffa
    public function getSalary(){
        return $this->findByListName(['key'=>'WAGEAMOUNT']);
    }

    // Periodo tariffa
    public function getSalaryPeriod(){
        return $this->findByListName(['key'=>'WAGEPERIOD']);
    }

    /** --- */

    public function enableOffer($offer_id){
        return $infoJobs->request('enableOffer',[ 'offerCode' => $offer_id ]);
    }

    public function disableOffer($offer_id){
        return $infoJobs->request('disableOffer',[ 'offerCode' => $offer_id ]);
    }

    public function eraseOffer($offer_id){
        return $infoJobs->request('eraseOffer',[ 'offerCode' => $offer_id ]);
    }


}