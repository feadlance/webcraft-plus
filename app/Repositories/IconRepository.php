<?php

namespace App\Repositories;

class IconRepository
{
	public static function keys()
	{
		$keys = [];

		foreach (self::all() as $key => $value) {
			$keys[] = $key;
		}

		return $keys;
	}

	public static function all()
	{
		return [
			'1-0' => '1-0',
			'1-1' => '1-1',
			'1-2' => '1-2',
			'1-3' => '1-3',
			'1-4' => '1-4',
			'1-5' => '1-5',
			'1-6' => '1-6',
			'10-0' => '10-0',
			'100-0' => '100-0',
			'101-0' => '101-0',
			'102-0' => '102-0',
			'103-0' => '103-0',
			'104-0' => '104-0',
			'105-0' => '105-0',
			'106-0' => '106-0',
			'107-0' => '107-0',
			'108-0' => '108-0',
			'109-0' => '109-0',
			'11-0' => '11-0',
			'110-0' => '110-0',
			'111-0' => '111-0',
			'112-0' => '112-0',
			'113-0' => '113-0',
			'114-0' => '114-0',
			'115-0' => '115-0',
			'116-0' => '116-0',
			'117-0' => '117-0',
			'118-0' => '118-0',
			'119-0' => '119-0',
			'12-0' => '12-0',
			'12-1' => '12-1',
			'120-0' => '120-0',
			'121-0' => '121-0',
			'122-0' => '122-0',
			'123-0' => '123-0',
			'124-0' => '124-0',
			'125-0' => '125-0',
			'125-1' => '125-1',
			'125-2' => '125-2',
			'125-3' => '125-3',
			'125-4' => '125-4',
			'125-5' => '125-5',
			'126-0' => '126-0',
			'126-1' => '126-1',
			'126-2' => '126-2',
			'126-3' => '126-3',
			'126-4' => '126-4',
			'126-5' => '126-5',
			'127-0' => '127-0',
			'128-0' => '128-0',
			'129-0' => '129-0',
			'13-0' => '13-0',
			'130-0' => '130-0',
			'131-0' => '131-0',
			'132-0' => '132-0',
			'133-0' => '133-0',
			'134-0' => '134-0',
			'135-0' => '135-0',
			'136-0' => '136-0',
			'137-0' => '137-0',
			'138-0' => '138-0',
			'139-0' => '139-0',
			'139-1' => '139-1',
			'14-0' => '14-0',
			'140-0' => '140-0',
			'141-0' => '141-0',
			'142-0' => '142-0',
			'143-0' => '143-0',
			'144-0' => '144-0',
			'145-0' => '145-0',
			'146-0' => '146-0',
			'147-0' => '147-0',
			'148-0' => '148-0',
			'149-0' => '149-0',
			'15-0' => '15-0',
			'150-0' => '150-0',
			'151-0' => '151-0',
			'152-0' => '152-0',
			'153-0' => '153-0',
			'154-0' => '154-0',
			'155-0' => '155-0',
			'155-1' => '155-1',
			'155-2' => '155-2',
			'156-0' => '156-0',
			'157-0' => '157-0',
			'158-0' => '158-0',
			'159-0' => '159-0',
			'159-1' => '159-1',
			'159-10' => '159-10',
			'159-11' => '159-11',
			'159-12' => '159-12',
			'159-13' => '159-13',
			'159-14' => '159-14',
			'159-15' => '159-15',
			'159-2' => '159-2',
			'159-3' => '159-3',
			'159-4' => '159-4',
			'159-5' => '159-5',
			'159-6' => '159-6',
			'159-7' => '159-7',
			'159-8' => '159-8',
			'159-9' => '159-9',
			'16-0' => '16-0',
			'160-0' => '160-0',
			'160-1' => '160-1',
			'160-10' => '160-10',
			'160-11' => '160-11',
			'160-12' => '160-12',
			'160-13' => '160-13',
			'160-14' => '160-14',
			'160-15' => '160-15',
			'160-2' => '160-2',
			'160-3' => '160-3',
			'160-4' => '160-4',
			'160-5' => '160-5',
			'160-6' => '160-6',
			'160-7' => '160-7',
			'160-8' => '160-8',
			'160-9' => '160-9',
			'161-0' => '161-0',
			'161-1' => '161-1',
			'162-0' => '162-0',
			'162-1' => '162-1',
			'163-0' => '163-0',
			'164-0' => '164-0',
			'165-0' => '165-0',
			'166-0' => '166-0',
			'167-0' => '167-0',
			'168-0' => '168-0',
			'168-1' => '168-1',
			'168-2' => '168-2',
			'169-0' => '169-0',
			'17-0' => '17-0',
			'17-1' => '17-1',
			'17-2' => '17-2',
			'17-3' => '17-3',
			'170-0' => '170-0',
			'171-0' => '171-0',
			'171-1' => '171-1',
			'171-10' => '171-10',
			'171-11' => '171-11',
			'171-12' => '171-12',
			'171-13' => '171-13',
			'171-14' => '171-14',
			'171-15' => '171-15',
			'171-2' => '171-2',
			'171-3' => '171-3',
			'171-4' => '171-4',
			'171-5' => '171-5',
			'171-6' => '171-6',
			'171-7' => '171-7',
			'171-8' => '171-8',
			'171-9' => '171-9',
			'172-0' => '172-0',
			'173-0' => '173-0',
			'174-0' => '174-0',
			'175-0' => '175-0',
			'175-1' => '175-1',
			'175-2' => '175-2',
			'175-3' => '175-3',
			'175-4' => '175-4',
			'175-5' => '175-5',
			'176-0' => '176-0',
			'177-0' => '177-0',
			'178-0' => '178-0',
			'179-0' => '179-0',
			'179-1' => '179-1',
			'179-2' => '179-2',
			'18-0' => '18-0',
			'18-1' => '18-1',
			'18-2' => '18-2',
			'18-3' => '18-3',
			'180-0' => '180-0',
			'181-0' => '181-0',
			'182-0' => '182-0',
			'183-0' => '183-0',
			'184-0' => '184-0',
			'185-0' => '185-0',
			'186-0' => '186-0',
			'187-0' => '187-0',
			'188-0' => '188-0',
			'189-0' => '189-0',
			'19-0' => '19-0',
			'19-1' => '19-1',
			'190-0' => '190-0',
			'191-0' => '191-0',
			'192-0' => '192-0',
			'193-0' => '193-0',
			'194-0' => '194-0',
			'195-0' => '195-0',
			'196-0' => '196-0',
			'197-0' => '197-0',
			'198-0' => '198-0',
			'199-0' => '199-0',
			'2-0' => '2-0',
			'20-0' => '20-0',
			'200-0' => '200-0',
			'201-0' => '201-0',
			'202-0' => '202-0',
			'203-0' => '203-0',
			'204-0' => '204-0',
			'205-0' => '205-0',
			'206-0' => '206-0',
			'207-0' => '207-0',
			'208-0' => '208-0',
			'209-0' => '209-0',
			'21-0' => '21-0',
			'210-0' => '210-0',
			'211-0' => '211-0',
			'212-0' => '212-0',
			'22-0' => '22-0',
			'2256-0' => '2256-0',
			'2257-0' => '2257-0',
			'2258-0' => '2258-0',
			'2259-0' => '2259-0',
			'2260-0' => '2260-0',
			'2261-0' => '2261-0',
			'2262-0' => '2262-0',
			'2263-0' => '2263-0',
			'2264-0' => '2264-0',
			'2265-0' => '2265-0',
			'2266-0' => '2266-0',
			'2267-0' => '2267-0',
			'23-0' => '23-0',
			'24-0' => '24-0',
			'24-1' => '24-1',
			'24-2' => '24-2',
			'25-0' => '25-0',
			'255-0' => '255-0',
			'256-0' => '256-0',
			'257-0' => '257-0',
			'258-0' => '258-0',
			'259-0' => '259-0',
			'26-0' => '26-0',
			'260-0' => '260-0',
			'261-0' => '261-0',
			'262-0' => '262-0',
			'263-0' => '263-0',
			'263-1' => '263-1',
			'264-0' => '264-0',
			'265-0' => '265-0',
			'266-0' => '266-0',
			'267-0' => '267-0',
			'268-0' => '268-0',
			'269-0' => '269-0',
			'27-0' => '27-0',
			'270-0' => '270-0',
			'271-0' => '271-0',
			'272-0' => '272-0',
			'273-0' => '273-0',
			'274-0' => '274-0',
			'275-0' => '275-0',
			'276-0' => '276-0',
			'277-0' => '277-0',
			'278-0' => '278-0',
			'279-0' => '279-0',
			'28-0' => '28-0',
			'280-0' => '280-0',
			'281-0' => '281-0',
			'282-0' => '282-0',
			'283-0' => '283-0',
			'284-0' => '284-0',
			'285-0' => '285-0',
			'286-0' => '286-0',
			'287-0' => '287-0',
			'288-0' => '288-0',
			'289-0' => '289-0',
			'29-0' => '29-0',
			'290-0' => '290-0',
			'291-0' => '291-0',
			'292-0' => '292-0',
			'293-0' => '293-0',
			'294-0' => '294-0',
			'295-0' => '295-0',
			'296-0' => '296-0',
			'297-0' => '297-0',
			'298-0' => '298-0',
			'299-0' => '299-0',
			'3-0' => '3-0',
			'3-1' => '3-1',
			'3-2' => '3-2',
			'30-0' => '30-0',
			'300-0' => '300-0',
			'301-0' => '301-0',
			'302-0' => '302-0',
			'303-0' => '303-0',
			'304-0' => '304-0',
			'305-0' => '305-0',
			'306-0' => '306-0',
			'307-0' => '307-0',
			'308-0' => '308-0',
			'309-0' => '309-0',
			'31-0' => '31-0',
			'31-1' => '31-1',
			'31-2' => '31-2',
			'310-0' => '310-0',
			'311-0' => '311-0',
			'312-0' => '312-0',
			'313-0' => '313-0',
			'314-0' => '314-0',
			'315-0' => '315-0',
			'316-0' => '316-0',
			'317-0' => '317-0',
			'318-0' => '318-0',
			'319-0' => '319-0',
			'32-0' => '32-0',
			'320-0' => '320-0',
			'321-0' => '321-0',
			'322-0' => '322-0',
			'322-1' => '322-1',
			'323-0' => '323-0',
			'324-0' => '324-0',
			'325-0' => '325-0',
			'326-0' => '326-0',
			'327-0' => '327-0',
			'328-0' => '328-0',
			'329-0' => '329-0',
			'33-0' => '33-0',
			'330-0' => '330-0',
			'331-0' => '331-0',
			'332-0' => '332-0',
			'333-0' => '333-0',
			'334-0' => '334-0',
			'335-0' => '335-0',
			'336-0' => '336-0',
			'337-0' => '337-0',
			'338-0' => '338-0',
			'339-0' => '339-0',
			'34-0' => '34-0',
			'340-0' => '340-0',
			'341-0' => '341-0',
			'342-0' => '342-0',
			'343-0' => '343-0',
			'344-0' => '344-0',
			'345-0' => '345-0',
			'346-0' => '346-0',
			'347-0' => '347-0',
			'348-0' => '348-0',
			'349-0' => '349-0',
			'349-1' => '349-1',
			'349-2' => '349-2',
			'349-3' => '349-3',
			'35-0' => '35-0',
			'35-1' => '35-1',
			'35-10' => '35-10',
			'35-11' => '35-11',
			'35-12' => '35-12',
			'35-13' => '35-13',
			'35-14' => '35-14',
			'35-15' => '35-15',
			'35-2' => '35-2',
			'35-3' => '35-3',
			'35-4' => '35-4',
			'35-5' => '35-5',
			'35-6' => '35-6',
			'35-7' => '35-7',
			'35-8' => '35-8',
			'35-9' => '35-9',
			'350-0' => '350-0',
			'350-1' => '350-1',
			'351-0' => '351-0',
			'351-1' => '351-1',
			'351-10' => '351-10',
			'351-11' => '351-11',
			'351-12' => '351-12',
			'351-13' => '351-13',
			'351-14' => '351-14',
			'351-15' => '351-15',
			'351-2' => '351-2',
			'351-3' => '351-3',
			'351-4' => '351-4',
			'351-5' => '351-5',
			'351-6' => '351-6',
			'351-7' => '351-7',
			'351-8' => '351-8',
			'351-9' => '351-9',
			'352-0' => '352-0',
			'353-0' => '353-0',
			'354-0' => '354-0',
			'355-0' => '355-0',
			'356-0' => '356-0',
			'357-0' => '357-0',
			'358-0' => '358-0',
			'359-0' => '359-0',
			'360-0' => '360-0',
			'361-0' => '361-0',
			'362-0' => '362-0',
			'363-0' => '363-0',
			'364-0' => '364-0',
			'365-0' => '365-0',
			'366-0' => '366-0',
			'367-0' => '367-0',
			'368-0' => '368-0',
			'369-0' => '369-0',
			'37-0' => '37-0',
			'370-0' => '370-0',
			'371-0' => '371-0',
			'372-0' => '372-0',
			'373-0' => '373-0',
			'374-0' => '374-0',
			'375-0' => '375-0',
			'376-0' => '376-0',
			'377-0' => '377-0',
			'378-0' => '378-0',
			'379-0' => '379-0',
			'38-0' => '38-0',
			'38-1' => '38-1',
			'38-2' => '38-2',
			'38-3' => '38-3',
			'38-4' => '38-4',
			'38-5' => '38-5',
			'38-6' => '38-6',
			'38-7' => '38-7',
			'38-8' => '38-8',
			'380-0' => '380-0',
			'381-0' => '381-0',
			'382-0' => '382-0',
			'383-100' => '383-100',
			'383-101' => '383-101',
			'383-120' => '383-120',
			'383-50' => '383-50',
			'383-51' => '383-51',
			'383-52' => '383-52',
			'383-54' => '383-54',
			'383-55' => '383-55',
			'383-56' => '383-56',
			'383-57' => '383-57',
			'383-58' => '383-58',
			'383-59' => '383-59',
			'383-60' => '383-60',
			'383-61' => '383-61',
			'383-62' => '383-62',
			'383-65' => '383-65',
			'383-66' => '383-66',
			'383-67' => '383-67',
			'383-68' => '383-68',
			'383-69' => '383-69',
			'383-90' => '383-90',
			'383-91' => '383-91',
			'383-92' => '383-92',
			'383-93' => '383-93',
			'383-94' => '383-94',
			'383-95' => '383-95',
			'383-96' => '383-96',
			'383-98' => '383-98',
			'384-0' => '384-0',
			'385-0' => '385-0',
			'386-0' => '386-0',
			'387-0' => '387-0',
			'388-0' => '388-0',
			'389-0' => '389-0',
			'39-0' => '39-0',
			'390-0' => '390-0',
			'391-0' => '391-0',
			'392-0' => '392-0',
			'393-0' => '393-0',
			'394-0' => '394-0',
			'395-0' => '395-0',
			'396-0' => '396-0',
			'397-0' => '397-0',
			'397-1' => '397-1',
			'397-2' => '397-2',
			'397-3' => '397-3',
			'397-4' => '397-4',
			'397-5' => '397-5',
			'398-0' => '398-0',
			'399-0' => '399-0',
			'4-0' => '4-0',
			'40-0' => '40-0',
			'400-0' => '400-0',
			'401-0' => '401-0',
			'402-0' => '402-0',
			'403-0' => '403-0',
			'404-0' => '404-0',
			'404' => '404',
			'405-0' => '405-0',
			'406-0' => '406-0',
			'407-0' => '407-0',
			'408-0' => '408-0',
			'409-0' => '409-0',
			'41-0' => '41-0',
			'410-0' => '410-0',
			'411-0' => '411-0',
			'412-0' => '412-0',
			'413-0' => '413-0',
			'414-0' => '414-0',
			'415-0' => '415-0',
			'416-0' => '416-0',
			'417-0' => '417-0',
			'418-0' => '418-0',
			'419-0' => '419-0',
			'42-0' => '42-0',
			'420-0' => '420-0',
			'421-0' => '421-0',
			'422-0' => '422-0',
			'423-0' => '423-0',
			'424-0' => '424-0',
			'425-0' => '425-0',
			'427-0' => '427-0',
			'428-0' => '428-0',
			'429-0' => '429-0',
			'43-0' => '43-0',
			'43-1' => '43-1',
			'43-2' => '43-2',
			'43-3' => '43-3',
			'43-4' => '43-4',
			'43-5' => '43-5',
			'43-6' => '43-6',
			'43-7' => '43-7',
			'430-0' => '430-0',
			'431-0' => '431-0',
			'432-0' => '432-0',
			'433-0' => '433-0',
			'434-0' => '434-0',
			'435-0' => '435-0',
			'436-0' => '436-0',
			'437-0' => '437-0',
			'438-0' => '438-0',
			'439-0' => '439-0',
			'44-0' => '44-0',
			'44-1' => '44-1',
			'44-2' => '44-2',
			'44-3' => '44-3',
			'44-4' => '44-4',
			'44-5' => '44-5',
			'44-6' => '44-6',
			'44-7' => '44-7',
			'440-0' => '440-0',
			'441-0' => '441-0',
			'442-0' => '442-0',
			'443-0' => '443-0',
			'444-0' => '444-0',
			'445-0' => '445-0',
			'446-0' => '446-0',
			'447-0' => '447-0',
			'448-0' => '448-0',
			'45-0' => '45-0',
			'46-0' => '46-0',
			'47-0' => '47-0',
			'48-0' => '48-0',
			'49-0' => '49-0',
			'5-0' => '5-0',
			'5-1' => '5-1',
			'5-2' => '5-2',
			'5-3' => '5-3',
			'5-4' => '5-4',
			'5-5' => '5-5',
			'50-0' => '50-0',
			'51-0' => '51-0',
			'52-0' => '52-0',
			'53-0' => '53-0',
			'54-0' => '54-0',
			'55-0' => '55-0',
			'56-0' => '56-0',
			'57-0' => '57-0',
			'58-0' => '58-0',
			'59-0' => '59-0',
			'6-0' => '6-0',
			'6-1' => '6-1',
			'6-2' => '6-2',
			'6-3' => '6-3',
			'6-4' => '6-4',
			'6-5' => '6-5',
			'60-0' => '60-0',
			'61-0' => '61-0',
			'62-0' => '62-0',
			'63-0' => '63-0',
			'64-0' => '64-0',
			'65-0' => '65-0',
			'66-0' => '66-0',
			'67-0' => '67-0',
			'68-0' => '68-0',
			'69-0' => '69-0',
			'7-0' => '7-0',
			'70-0' => '70-0',
			'71-0' => '71-0',
			'72-0' => '72-0',
			'73-0' => '73-0',
			'74-0' => '74-0',
			'75-0' => '75-0',
			'76-0' => '76-0',
			'77-0' => '77-0',
			'78-0' => '78-0',
			'79-0' => '79-0',
			'8-0' => '8-0',
			'80-0' => '80-0',
			'81-0' => '81-0',
			'82-0' => '82-0',
			'83-0' => '83-0',
			'84-0' => '84-0',
			'85-0' => '85-0',
			'86-0' => '86-0',
			'87-0' => '87-0',
			'88-0' => '88-0',
			'89-0' => '89-0',
			'9-0' => '9-0',
			'90-0' => '90-0',
			'91-0' => '91-0',
			'92-0' => '92-0',
			'93-0' => '93-0',
			'94-0' => '94-0',
			'95-0' => '95-0',
			'95-1' => '95-1',
			'95-10' => '95-10',
			'95-11' => '95-11',
			'95-12' => '95-12',
			'95-13' => '95-13',
			'95-14' => '95-14',
			'95-15' => '95-15',
			'95-2' => '95-2',
			'95-3' => '95-3',
			'95-4' => '95-4',
			'95-5' => '95-5',
			'95-6' => '95-6',
			'95-7' => '95-7',
			'95-8' => '95-8',
			'95-9' => '95-9',
			'96-0' => '96-0',
			'97-0' => '97-0',
			'97-1' => '97-1',
			'97-2' => '97-2',
			'97-3' => '97-3',
			'97-4' => '97-4',
			'97-5' => '97-5',
			'98-0' => '98-0',
			'98-1' => '98-1',
			'98-2' => '98-2',
			'98-3' => '98-3',
			'99-0' => '99-0'
		];
	}
}