<?php 
    $cat1_list = mysql_query("SELECT id,title_tc FROM cat1 WHERE status=1 ORDER BY seq");
    $char_a_assii=96;

    $cat1 = isset($_GET['cat1'])?$_GET['cat1']:1;
    $cat2_list = mysql_query("SELECT id,title_tc FROM cat2 WHERE status=1 AND cat1=$cat1 ORDER BY seq");
?>
<script type="text/javascript" src="js/common.js"></script>
<a href="#content" class="ui_skip">跳至內容</a>
<div id="logo">
    <div>
        <h1 class="ui_nomp"><a href="b5_index.php"><img src="images/logo.png" width="155" height="120" alt=""/></a></h1>
    </div>
</div>
<div id="navroot">
    <div id="nav1">
        <ul class="ui_nomp ui_nolst">
        <?php while($cat1_row=mysql_fetch_array($cat1_list)){ 
            $char_a_assii+=1;
            $cat2_id = getValueFromTableByCon("id","cat2","cat1",$cat1_row['id']);
            $cat3_id = getValueFromTableByCon("id","cat3","cat2",$cat2_id) ?>
            <li id="nav1_<?=chr($char_a_assii)?>"><a href="b5_cat_details.php?cat1=<?=$cat1_row['id']?>&cat2=<?=$cat2_id?>&cat3=<?=$cat3_id?>"><?=$cat1_row['title_en']?></a></li>
        <?php } ?>
        <!--    <li id="nav1_a"><a href="b5_cat_details.php?cat1=1&cat2=1&cat3=1">超級市場</a></li>
            <li id="nav1_b"><a href="b5_wine.php">美酒佳餚</a></li>
            <li id="nav1_c"><a href="b5_beauty.php">美容護膚</a></li>
            <li id="nav1_d"><a href="b5_gift.php">節日禮籃</a></li>
            <li id="nav1_e"><a href="b5_mustbuy.php">全城優惠</a></li> -->
        </ul>
    </div>
    <div id="nav2">
        <ul id="nav2a" class="ui_nolst ui_nomp">
            <li>
                <a href="javascript:void(0);" onclick="hideCategories()"><img src="images/bg_nav2_more.jpg" width="212" height="38" alt="商品分類"/></a>
                <div id="nav2a2">
                    <ul class="ui_nolst ui_nomp">
                     <!--   <li class="menu_category_item">
                            <a href="javascript:void(0);">類別 A</a>
                            <div class="ui_nav2_sub">
                                <div>
                                    <p class="ui_nav2_subtitle">類別 A</p>
                                    <ul class="ui_nolst ui_nomp">
                                        <li><a href="b5_supermarket.php">水果蔬菜</a></li>
                                        <li><a href="javascript:void(0);">水果</a></li>
                                        <li><a href="javascript:void(0);">水果蔬菜</a></li>
                                        <li><a href="javascript:void(0);">蔬菜</a></li>
                                        <li><a href="javascript:void(0);">蔬果</a></li>
                                        <li><a href="javascript:void(0);">水菜</a></li>
                                        <li><a href="javascript:void(0);">水果蔬菜水果蔬菜</a></li>
                                        <li><a href="javascript:void(0);">水果蔬菜</a></li>
                                        <li><a href="javascript:void(0);">水蔬</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li> -->
                        <?php while($cat2_row=mysql_fetch_array($cat2_list)){ ?>
                            <li class="menu_category_item">
                            <a href="javascript:void(0);"><?=$cat2_row['title_tc']?></a>
                            <div class="ui_nav2_sub">
                                <div>
                                <p class="ui_nav2_subtitle"><?=$cat2_row['title_tc']?></p>
                                <ul class="ui_nolst ui_nomp">
                                <?php 
                                $cat3_list = mysql_query("SELECT id,title_tc FROM cat3 WHERE status=1 AND cat1=$cat1 AND cat2='".$cat2_row['id']."' ORDER BY seq");
                                while ($cat3_row=mysql_fetch_array($cat3_list)){ ?> 
                                    <li><a href="b5_cat_details.php?cat1=<?=$cat1?>&cat2=<?=$cat2_row['id']?>&cat3=<?=$cat3_row['id']?>"><?=$cat3_row['title_tc']?></a></li>
                                <?php } ?>
                                </ul>
                                </div>
                            </div>
                        <?php } ?>
                    </ul>
                </div>
            </li>
            <li>
            <form name="form1" id="form1" action="b5_search.php" method="get" >
            <input type="text" placeholder="搜尋" class="ui_search" name="search_text" required><input type="submit" class="ui_btn_search" value="">
            </form>
            </li>
        </ul>
        <ul id="nav2b" class="ui_nolst ui_nomp" style="width:500px;">
            <?php if(isset($_SESSION["member"]) && $_SESSION["member"]["name_tc"]!=""){ ?>
            <li id="nav2b_1"><a href="b5_member.php">你好 <?=$_SESSION["member"]["name_tc"]?></a></li>
            <li id="nav2b_1"><a href="javascript:void(0);" onclick="javascript:if(confirm('確定登出?'))memberLogout()">登出</a></li>
            <?php }else{ ?>
            <li id="nav2b_1"><a href="b5_login.php">登入</a></li>
            <li id="nav2b_2"><a href="b5_reg.php">註冊</a></li>
             <?php } ?>
            <li id="nav2b_3"><a href="b5_mylist.php">我的清單</a></li>
            <li id="nav2b_4"><a href="b5_cart.php">購物車</a></li>
        </ul>
    </div>
</div>