<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use \user_class\Pict;
if (0 < $arResult['SECTIONS_COUNT']) {
	$boolPicture = false;
	$boolDescr = false;
	$arSelect = array('ID');
	$arMap = array();
	reset($arResult['SECTIONS']);
	$arCurrent = current($arResult['SECTIONS']);
	if (!isset($arCurrent['PICTURE'])) {
		$boolPicture = true;
		$arSelect[] = 'PICTURE';
	}
	if (!array_key_exists('DESCRIPTION', $arCurrent)) {
		$boolDescr = true;
		$arSelect[] = 'DESCRIPTION';
		$arSelect[] = 'DESCRIPTION_TYPE';
	}
	if ($boolPicture || $boolDescr) {
		foreach ($arResult['SECTIONS'] as $key => $arSection) {
			$arMap[$arSection['ID']] = $key;
		}
		$rsSections = CIBlockSection::GetList(array(), array('ID' => array_keys($arMap)), false, $arSelect);
		while ($arSection = $rsSections->GetNext()) {
			if (!isset($arMap[$arSection['ID']])) {
				continue;
			}
			$key = $arMap[$arSection['ID']];
			if ($boolPicture) {
				$arSection['PICTURE'] = intval($arSection['PICTURE']);
				$arSection['PICTURE'] = (0 < $arSection['PICTURE'] ? CFile::GetFileArray($arSection['PICTURE']) : false);
				$arResult['SECTIONS'][$key]['PICTURE'] = $arSection['PICTURE'];
				$arResult['SECTIONS'][$key]['~PICTURE'] = $arSection['~PICTURE'];
			}
			if ($boolDescr) {
				$arResult['SECTIONS'][$key]['DESCRIPTION'] = $arSection['DESCRIPTION'];
				$arResult['SECTIONS'][$key]['~DESCRIPTION'] = $arSection['~DESCRIPTION'];
				$arResult['SECTIONS'][$key]['DESCRIPTION_TYPE'] = $arSection['DESCRIPTION_TYPE'];
				$arResult['SECTIONS'][$key]['~DESCRIPTION_TYPE'] = $arSection['~DESCRIPTION_TYPE'];
			}
		}
	}
	unset($arMap);
	$arSelect = Array('ID', 'NAME', 'IBLOCK_SECTION_ID', 'PICTURE');
	$arFilter = Array('IBLOCK_ID' => $arParams['IBLOCK_ID'], 'ACTIVE' => 'Y');
	$res = CIBlockSection::GetList(Array(), $arFilter, true, $arSelect);
	while($ob = $res->GetNextElement()) {
		$arFields = $ob->GetFields();
		$default_picture_array = CFile::GetByID($arFields['PICTURE']);
		$arFile = $default_picture_array->Fetch();
		$arrImages[$arElement['ID']][] = $arFile;
		$default_picture = $arFile;
		$new_width = 1100;
		$new_height = ceil($new_width * $default_picture['HEIGHT'] / $default_picture['WIDTH']);
		$webp_resize = Pict::getResizeWebpSrc($default_picture, $new_width, $new_height, $isProportional = true, $intQuality = 40);
		$arSec[$arFields['IBLOCK_SECTION_ID']][] = $webp_resize;
	}
	foreach ($arResult['SECTIONS'] as $key => $arSection) {
		$counter = 0;
		if($arResult['SECTIONS'][$key]['DEPTH_LEVEL'] == 1) {
			if(!empty($arSec[$arSection['ID']])) {
				$arResult['SECTIONS'][$key]['CHILD_SECTIONS_PICTURES'] = $arSec[$arSection['ID']];

			}
			$counter++;
		} else {
			unset($arResult['SECTIONS'][$key]);
		}
		$arResult['SECTIONS'][$key]['SECTIONS_CNT'] = $counter;
		echo '<br />name: '.$arResult['SECTIONS'][$key]['NAME'].'; counter: '.$counter;
	}
//	pre($arResult);
}?>