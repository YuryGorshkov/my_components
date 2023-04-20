<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
$this->setFrameMode(true);

if (!empty($_GET['YEAR'])) {
  $current_year = $_REQUEST['YEAR'];
} else {
  $current_year = null;
}
?>
  <div class="newsblock">
    <div class="box1">
      <p>Список новостей (<?=count($arResult["ALL_ITEMS"])?> шт.)</p>
      <hr>
      <p class="tabs"><?
	  		$dates = array();
			foreach($arResult["ALL_ITEMS"] as $arItem){

				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				if($arParams["DISPLAY_DATE"]!="N" && $arItem["ACTIVE_FROM"]){
					$datetime = $arItem["ACTIVE_FROM"];
					$arr = ParseDateTime($datetime, FORMAT_DATETIME);
					$dates[] = $arr["YYYY"];
				}
			}
			$dates = array_unique($dates);
      natsort($dates);
      $dates = array_reverse($dates);
			?>

				<?
					foreach($dates as $year){
						echo '<a href="?YEAR='.$year.'" style="margin-right: 10px;">'.$year.'</a>';
					}
				?>
				</span>
			</p>
      <div class="newscont">
        <?php if ($current_year == null): ?>

	  	<?foreach($arResult["ITEMS"] as $arItem):?>

  			<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
  			<span class="news-date-time"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></span>
  		<?endif?>
  		<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
  			<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
  				<a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><b><?echo $arItem["NAME"]?></b></a><br />
  			<?else:?>
  				<b><?echo $arItem["NAME"]?></b><br />
  			<?endif;?>
  		<?endif;?>
  		<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
  			<?echo $arItem["PREVIEW_TEXT"];?>
  		<?endif;?><br><br>

		<?endforeach;?>
    <?else:?>
    <?foreach($arResult["ALL_ITEMS"] as $arItem):

    $datetime = $arItem["ACTIVE_FROM"];
    $arr = ParseDateTime($datetime, FORMAT_DATETIME);
     if ($arr["YYYY"] == $current_year):?>
      <?if($arParams["DISPLAY_DATE"]!="N" && $arItem["ACTIVE_FROM"]):?>
      <span class="news-date-time"><?echo $arItem["ACTIVE_FROM"]?></span>
    <?endif?>
    <?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
      <?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
        <a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><b><?echo $arItem["NAME"]?></b></a><br />
      <?else:?>
        <b><?echo $arItem["NAME"]?></b><br />
      <?endif;?>
    <?endif;?>
    <?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
      <?echo $arItem["PREVIEW_TEXT"];?>
    <?endif;?><br><br>
  <?php endif; ?>

  <?endforeach;?>
  <?php endif; ?>
      </div>
      <div class="navbar">

        <?$dbresult =& $arResult["NAV_RESULT"];
        if(intval($dbresult->NavPageSize) <= 0)
          $dbresult->NavPageSize = 10;
        $arResult["NavPageCount"] = $dbresult->NavPageCount;
        $arResult["NavNum"] = $dbresult->NavNum;
        ?>
        <div class="main-ui-pagination">
          <div class="main-ui-pagination-pages">
            <div class="main-ui-pagination-label" style="display: inline-block;">Постраничная навигация: </div>
            <div class="main-ui-pagination-pages-list" style="display: inline-block;">
                <?for ($i=1; $i <= $arResult["NavPageCount"]; $i++) {
                  echo  '<a class="main-ui-pagination-page" href="?PAGEN_'.$arResult["NavNum"].'='.$i.'" style="margin-left: 5px;">'.$i.'</a>';
                }?>
            </div>
          </div>
        </div>


      </div>
    </div>
</div>
