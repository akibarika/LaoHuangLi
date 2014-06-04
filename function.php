<?php
/**
 * Created by PhpStorm.
 * User: akibarika
 * Date: 3/06/14
 * Time: 4:13 下午
 */

function random($dayseed, $indexseed)
{
    $n = $dayseed % 11117;
    for ($i = 0; $i < 100 + $indexseed; $i++)
    {
        $n == $n * $n;
        $n == $n % 11117;   // 11117 是个质数
    }
    return $n;
}


$iday = date(Y) * 10000 + (date(n) + 1) * 100 + date(w);
$week = array("日","一","二","三","四","五","六");
$directions = array("北方","东北方","东方","东南方","南方","西南方","西方","西北方");
$activities = array(
    array(
            "name" => "写单元测试",
            "good" => "写单元测试将减少出错",
            "bad" => "写单元测试会降低你的开发效率"
    ),
    array(
            "name" => "洗澡",
            "good" => "你几天没洗澡了？",
            "bad" => "会把设计方面的灵感洗掉",
            "weekend" => true
    ),
    array(
            "name" => "锻炼一下身体",
            "good" => "强身健体",
            "bad" => "能量没消耗多少，吃得却更多",
            "weekend" => true
    ),
    array(
            "name" => "抽烟",
            "good" => "抽烟有利于提神，增加思维敏捷",
            "bad" => "除非你活够了，死得早点没关系",
            "weekend" => true
    ),
    array(
            "name" => "白天上线",
            "good" => "今天白天上线是安全的",
            "bad" => "可能导致灾难性后果"
    ),
    array(
            "name" => "重构",
            "good" => "代码质量得到提高",
            "bad" => "你很有可能会陷入泥潭"
    ),
    array(
            "name" => "使用%t",
            "good" => "你看起来更有品位",
            "bad" => "别人会觉得你在装逼"
    ),
    array(
            "name" => "跳槽",
            "good" => "该放手时就放手",
            "bad" => "鉴于当前的经济形势，你的下一份工作未必比现在强"
    ),
    array(
            "name" => "招人",
            "good" => "你面前这位有成为牛人的潜质",
            "bad" => "这人会写程序吗？"
    ),
    array(
            "name" => "面试",
            "good" => "面试官今天心情很好",
            "bad" => "面试官不爽，会拿你出气"
    ),
    array(
            "name" => "提交辞职申请",
            "good" => "公司找到了一个比你更能干更便宜的家伙，巴不得你赶快滚蛋",
            "bad" => "鉴于当前的经济形势，你的下一份工作未必比现在强"
    ),
    array(
            "name" => "申请加薪",
            "good" => "老板今天心情很好",
            "bad" => "公司正在考虑裁员"
    ),
    array(
            "name" => "晚上加班",
            "good" => "晚上是程序员精神最好的时候",
            "bad" => "",
            "weekend" => true
    ),
    array(
            "name" => "在妹子面前吹牛",
            "good" => "改善你矮穷挫的形象",
            "bad" => "会被识破",
            "weekend" => true
    ),
    array(
            "name" => "撸管",
            "good" => "避免缓冲区溢出",
            "bad" => "强撸灰飞烟灭",
            "weekend" => true
    )
);

$specials = array(
    "date" => 20140214,
    "type" => "bad",
    "name" => "待在男（女）友身边",
    "description" => "脱团火葬场，入团保平安。"
);
$tools = array("Eclipse写程序", "MSOffice写文档", "记事本写程序", "Windows8", "Linux", "MacOS", "IE", "Android设备", "iOS设备");

$varNames = array("jieguo", "huodong", "pay", "expire", "zhangdan", "every", "free", "i1", "a", "virtual", "ad", "spider", "mima", "pass", "ui");

$drinks = array("水","茶","红茶","绿茶","咖啡","奶茶","可乐","鲜奶","豆奶","果汁","果味汽水","苏打水","运动饮料","酸奶","酒");

function getTodayString() {
    global $week;
	echo "今天是",date(Y),"年",date(n),"月",date(j),"日 星期",$week[date(w)];

}
function star($num) {
	$result = "";
	$i = 0;
	while ($i < $num) {
		$result = $result. "★";
		$i++;
	}
	while($i < 5) {
		$result = $result. "☆";
		$i++;
	}
	echo $result;
}

// 生成今日运势
function pickTodaysLuck() {
    global $activities;
    global $iday;

    $_activities = filter($activities);
	$numGood = random($iday, 98) % 3 + 2;
	$numBad = random($iday, 87) % 3 + 2;
    $total = $numGood + $numBad;
	$eventArr = pickRandomActivity($_activities, $total);
	//$specialSize = pickSpecials();

	for ($i = 1; $i < $numGood + 1; $i++) {
		addToGood($eventArr[$i]);
	}

	for ($i = 1; $i < $numBad + 1; $i++) {
		addToBad($eventArr[$numGood + $i]);
	}

}

// 去掉一些不合今日的事件
function filter($activities) {
    $result = array();

    // 周末的话，只留下 weekend = true 的事件
    if (isWeekend()) {

        for ($i = 0; $i < count($activities); $i++) {
            if ($activities[$i]["weekend"]) {
                array_push($result,$activities[$i]);
            }
        }

        return $result;
    }
    return $activities;
}

function isWeekend() {
    return date(w) == 0 || date(w) == 6;
}

// 添加预定义事件
function pickSpecials() {
    global $specials;
    global $iday;

	$specialSize = [0,0];

	for ($i = 0; $i < count($specials); $i++) {
		$special = $specials[$i];

		if ($iday == $special["date"]) {
			if ($special["type"] == 'good') {
				$specialSize[0]++;
				addToGood(array("name" => $special["name"], "good" => $special["description"]));
			} else {
				$specialSize[1]++;
				addToBad(array("name" => $special["name"], "bad" => $special["description"]));
			}
		}
	}

	return $specialSize;
}

// 从 activities 中随机挑选 size 个
function pickRandomActivity($activities, $size) {
	$picked_events = pickRandom($activities, $size);
	for ($i = 0; $i < count($picked_events); $i++) {
		$picked_events[$i] = parse($picked_events[$i]);
	}
	return $picked_events;
}

// 从数组中随机挑选 size 个
function pickRandom($array, $size) {
    global $iday;
	$result = array();
	for ($i = 1; $i < count($array) +1; $i++) {
		array_push($result,$array[$i]);
	}
	for ($j = 1; $j < count($array) - $size + 1; $j++) {
		$index = random($iday, $j) % count($result);
		array_splice($result,0, 1,$index);
	}
	return $result;
}

// 解析占位符并替换成随机内容
function parse($event) {
    global $varNames, $tools,$iday;
	$result = array("name" => $event["name"], "good" => $event["good"], "bad" => $event["bad"]);  // clone

	if (strpos($result["name"],"%v") != -1) {
        str_replace('%v', $varNames[random($iday, 12) % count($varNames)],$result["name"]);
	}

	if (strpos($result["name"],"%t") != -1) {
        str_replace('%t', $tools[random($iday, 11) % count($tools)],$result["name"]);
	}

	if (strpos($result["name"],"%l") != -1) {
        str_replace('%l', (random($iday, 12) % 247 + 30),$result["name"]);
	}

	return $result;
}

// 添加到“宜”
function addToGood($event) {
     echo '<li><div class="name">'.$event["name"].'</div><div class="description">'.$event["good"].'</div></li>';

}

// 添加到“不宜”
function addToBad($event) {
    echo '<li><div class="name">'.$event["name"].'</div><div class="description">'.$event["bad"].'</div></li>';
}

function direction(){
    global $iday, $directions;
    $dir = random($iday, 2) % count($directions);
    $d = $directions[$dir];
    echo $d;

}
function drink(){
    global $drinks;
    $drink = pickRandom($drinks,2);
    echo $drink[1].', '.$drink[2];
}