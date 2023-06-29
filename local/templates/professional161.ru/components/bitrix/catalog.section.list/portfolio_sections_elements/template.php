<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \user_class\Pict;
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<div class="row no-gutters">
<?if (0 < $arResult['SECTIONS_COUNT']) {
	foreach ($arResult['SECTIONS'] as &$arSection) {
		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
		if (false === $arSection['PICTURE']) {
			$arSection['PICTURE'] = array(
				'SRC' => $arCurView['EMPTY_IMG'],
				'ALT' => (
					'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
					? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_ALT"]
					: $arSection["NAME"]
				),
				'TITLE' => (
					'' != $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
					? $arSection["IPROPERTY_VALUES"]["SECTION_PICTURE_FILE_TITLE"]
					: $arSection["NAME"]
				)
			);
		}
		if(!empty($arSection['PICTURE']['SRC'])) {
			$default_picture = $arSection['PICTURE'];
			$new_width = 1100;
			$new_height = ceil($new_width * $default_picture['HEIGHT'] / $default_picture['WIDTH']);
			$webp_resize = Pict::getResizeWebpSrc($default_picture, $new_width, $new_height, $isProportional = true, $intQuality = 40);
		}
		if(!empty($arSection['PICTURE']) && count($arSection['CHILD_SECTIONS_PICTURES']) > 0) {
			$div_lg_class = 'col-lg-12';
			$div_all_class = 12;
			$column_lg_class = 12 / (count($arSection['CHILD_SECTIONS_PICTURES']) + 1);
			$div_column = true;
/*			$div_column = '
<div class="row no-gutters">
	<div class="col-lg-'.$column_lg_class.' col-md-6 col-sm-6">
		<a href="'.$arSection['SECTION_PAGE_URL'].'" title="'.$arSection['PICTURE']['TITLE'].'">
			<img src="'.$arSection['CHILD_SECTIONS_PICTURES'][0].'" alt="фото для &laquo;'.$arSection['NAME'].'" width="'.$new_width.'" height="'.$new_height.'" />
		</a>
	</div>
</div>';*/
		} else {
			$div_lg_class = 'col-lg';
			$div_all_class = 6;
			$div_column = false;
		}
		?>
		<div id="<?=$this->GetEditAreaId($arSection['ID'])?>" class="<?=$div_lg_class?> col-md-<?=$div_all_class?> col-sm-<?=$div_all_class?>">
		<?if($div_column == true) {?>
			<div class="row no-gutters">
				<div class="col-lg-<?=$column_lg_class?> col-md-6 col-sm-6">
					<a href="<?=$arSection['SECTION_PAGE_URL']?>" title="<?=$arSection['PICTURE']['TITLE']?>">
						<img src="<?=$webp_resize?>" alt="<?if(!empty($default_picture['TITLE'])){?><?=$default_picture['TITLE']?>, фото для &laquo;<?=$arSection['NAME']?>&raquo;<?}else{?><?=$arSection['NAME']?>, фото для &laquo;<?=$arSection['NAME']?>&raquo;<?}?>" width="<?=$new_width?>" height="<?=$new_height?>" />
					</a>
				</div>
			<?foreach ($arSection['CHILD_SECTIONS_PICTURES'] as $child_picture) {?>
				<div class="col-lg-<?=$column_lg_class?> col-md-6 col-sm-6">
					<a href="<?=$arSection['SECTION_PAGE_URL']?>" title="<?=$arSection['PICTURE']['TITLE']?>">
						<img src="<?=$child_picture?>" alt="фото для &laquo;<?=$arSection['NAME']?>" width="<?=$new_width?>" height="<?=$new_height?>" />
					</a>
				</div>
			<?}?>
			</div>
		<?} else {?>
			<a href="<?=$arSection['SECTION_PAGE_URL']?>" title="<?=$arSection['PICTURE']['TITLE']?>">
				<img src="<?=$webp_resize?>" alt="<?if(!empty($default_picture['TITLE'])){?><?=$default_picture['TITLE']?>, фото для &laquo;<?=$arSection['NAME']?>&raquo;<?}else{?><?=$arSection['NAME']?>, фото для &laquo;<?=$arSection['NAME']?>&raquo;<?}?>" width="<?=$new_width?>" height="<?=$new_height?>" />
				<h3>
					<a href="<?=$arSection['SECTION_PAGE_URL']?>">
						<?=$arSection['NAME']?>
					</a>
					<?if ($arParams["COUNT_ELEMENTS"]) {?>
						<span>(<?=$arSection['ELEMENT_CNT']?>)</span>
					<?}?>
				</h3>
			</a>
		<?}?>
		</div>
	<?}
}?>
</div>