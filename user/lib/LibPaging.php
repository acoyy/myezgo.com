<?php
	function func_setPageView($pv='') {
		if ($pv) {
			$_SESSION["pageView"] = $pv;
		} else {
	    if ($_GET["pageView"] == "" || empty($_GET["pageView"]) || $_GET["pageView"] == undefined) {
				// if (!$_SESSION["pageView"]) {
					$_SESSION["pageView"] = 'grid';
				// }
	    } else {
	      $_SESSION["pageView"] = $_GET["pageView"];
	    }
		}
	}
	
	function func_getPageView() {
		if ($_SESSION["pageView"]) {
			return $_SESSION["pageView"];
		} else {
			return 'grid';
		}
	}
	
	//=======================================================================================================================
	function func_setPage() {
    if ($_GET["page"] == "" || empty($_GET["page"]) || $_GET["page"] == undefined) {
      $_SESSION["page"] = 1;
    } else {
      $_SESSION["page"] = $_GET["page"];
    }
	}
	
	function func_setAjaxPage() {
    if ($_GET["page"] == "" || empty($_GET["page"]) || $_GET["page"] == undefined) {
      $_SESSION["ajaxPage"] = 1;
    } else {
      $_SESSION["ajaxPage"] = $_GET["page"];
    }
	}	
	
	function func_getPage() {
    return $_SESSION["page"];
	}

	function func_getAjaxPage() {
    return $_SESSION["ajaxPage"];
	}
 	
	function func_clrPage() {
    unset($_SESSION["page"]);
	}
	
	function func_clrAjaxPage() {
    unset($_SESSION["ajaxPage"]);
	}
 	
	//============================================================================================================================================

	function func_setOffset() {
    $_SESSION["offset"] = ($_SESSION["page"]-1) * $_SESSION["limit"];
	}
	
	function func_setAjaxOffset() {
    $_SESSION["ajaxOffsets"] = ($_SESSION["ajaxPage"]-1) * $_SESSION["ajaxLimit"];
	}	
 	
	function func_getOffset() {
    return $_SESSION["offset"];
	}
	
	function func_getAjaxOffset() {
    return $_SESSION["ajaxOffsets"];
	}
 	
	function func_clrOffset() {
    unset($_SESSION["offset"]);
	}
	
	function func_clrAjaxOffset() {
    unset($_SESSION["ajaxOffsets"]);
	}
 	
	//============================================================================================================================================
	function func_setLimit($num) {
		global $isPaging;
    $isPaging = true;
		$_SESSION["limit"] = $num;
	}
	
	function func_setAjaxLimit($num) {
		global $isPaging;
    $isPaging = true;
    $_SESSION["ajaxLimit"] = $num;
	}
 	
	function func_getLimit() {
    return $_SESSION["limit"];
	}
	
	function func_getAjaxLimit() {
    return $_SESSION["ajaxLimit"];
	}	
 	
	function func_setTotalPage($row) {
    if ($row % func_getLimit() == 0) {
      $_SESSION["total"] = ($row / $_SESSION["limit"]);
    } else {
      $_SESSION["total"] = ($row / $_SESSION["limit"])+1;
    }
	}
 	
	function func_setAjaxTotalPage($row) {
	    if ($row % func_getAjaxLimit() == 0) {
	      $_SESSION["ajaxTotal"] = ($row / $_SESSION["ajaxLimit"]);
	    } else {
	      $_SESSION["ajaxTotal"] = ($row / $_SESSION["ajaxLimit"])+1;
	    }
	}	
	
	function func_getTotalPage() {
		return (int)$_SESSION["total"];
	}
	
	function func_getAjaxTotalPage() {
		return (int)$_SESSION["ajaxTotal"];
	}

	//============================================================================================================================================

	function func_getPaging($page,$get=true) {
		//if ($get) $page = getURL($page);
		if (func_getTotalPage() > 10) {
			if (func_getTotalPage() - func_getPage() <= 5 ) {
				$start_page = func_getPage() - (10 - ((func_getTotalPage() - func_getPage()) + 1));
				$end_page = func_getTotalPage();
			} else {
				if (func_getPage() - 4 <= 1 ) {
					$start_page = 1;
					$end_page = 10;
				} else {
					$start_page = func_getPage() - 4;
					$end_page = func_getPage() + 5;
				}
			}
		} else {
			$start_page = 1;
			$end_page = func_getTotalPage();
		}

		if (func_getTotalPage() > 0 ) {
			if (func_getPage() > 1 && func_getPage() != 1) { 
				echo '<a href="'.$page.'&page=' . ($_SESSION["page"]-1) . '">Prev</a>';
			} else {
				echo 'Prev';
			}
			
			echo '&nbsp;';

			for($i=$start_page;$i<=$end_page;$i++) {
				if ($i == func_getPage()) {
					echo '<b>'.$i.'</b>&nbsp;';
				} else {
					if(strrpos($page,"?")===FALSE){
						echo '<a href="' . $page . '?page=' . $i . '">'.$i.'</a>&nbsp;';
					}else{
						echo '<a href="' . $page . '&page=' . $i . '">'.$i.'</a>&nbsp;';
					}
				}
			}
			
		    if (func_getPage() < func_getTotalPage() && func_getPage() != func_getTotalPage()) {
					echo '<a href="'.$page.'&page=' . (func_getPage()+1).'">Next</a>';
		    } else {
					echo 'Next';
			}
		}
	}
	
	function func_getAjaxPaging($page,$div='content',$ret=false) {
		$s = (strrpos($page,"?")===FALSE) ? '?' : '&';
		
		if (func_getAjaxTotalPage() > 10) {
			if (func_getAjaxTotalPage() - func_getAjaxPage() <= 5 ) {
				$start_page = func_getAjaxPage() - (10 - ((func_getAjaxTotalPage() - func_getAjaxPage()) + 1));
				$end_page = func_getAjaxTotalPage();
			} else {
				if (func_getAjaxPage() - 4 <= 1 ) {
					$start_page = 1;
					$end_page = 10;
				} else {
					$start_page = func_getAjaxPage() - 4;
					$end_page = func_getAjaxPage() + 5;
				}
			}
		} else {
			$start_page = 1;
			$end_page = func_getAjaxTotalPage();
		}

		if (func_getAjaxTotalPage() > 0 ) {
			if (func_getAjaxPage() > 1 && func_getAjaxPage() != 1) { 
				$output .= '<a href="javascript:void(0)" onclick="loadAjax(\''.$page.$s.'page=' . (func_getAjaxPage()-1) . '&pageView='.func_getPageView().'\', \''. $div .'\')">Prev</a>';
			} else {
				$output .= 'Prev';
			}
			
			$output .= '&nbsp;';

			for($i=$start_page;$i<=$end_page;$i++) {
				if ($i == func_getAjaxPage()) {
					$output .= '<b>'.$i.'</b>&nbsp;';
				} else {
					$output .= '<a href="javascript:void(0)" onclick="loadAjax(\''.$page.$s.'page=' . $i . '&pageView='.func_getPageView().'\', \''. $div .'\')">'.$i.'</a>&nbsp;';
				}
			}

			if (func_getAjaxPage() < func_getAjaxTotalPage() && func_getAjaxPage() != func_getAjaxTotalPage()) {
				$output .= '<a href="javascript:void(0)" onclick="loadAjax(\''.$page.$s.'page=' . (func_getAjaxPage()+1) . '&pageView='.func_getPageView().'\', \''. $div .'\')">Next</a>';
			} else {
				$output .= 'Next';
			}
		}
		
		if ($ret) {
			return $output;
		} else {
			echo "<div style='position:absolute;top:700px;text-align:center;width:911px'>" .$output."</div>";
		}
	}
	
	function func_getPaging_2($page,$get=true) {
		if ($get) $page = getURL($page);
		if (func_getTotalPage() > 10) {
			if (func_getTotalPage() - func_getPage() <= 5 ) {
				$start_page = func_getPage() - (10 - ((func_getTotalPage() - func_getPage()) + 1));
				$end_page = func_getTotalPage();
			} else {
				if (func_getPage() - 4 <= 1 ) {
					$start_page = 1;
					$end_page = 10;
				} else {
					$start_page = func_getPage() - 4;
					$end_page = func_getPage() + 5;
				}
			}
		} else {
			$start_page = 1;
			$end_page = func_getTotalPage();
		}
		

		if (func_getTotalPage() > 0 ) {
			echo '<table cellpadding="0" cellspacing="4" border="0" class="page"><tr>';
			if (func_getPage() > 1 && func_getPage() != 1) { 
				echo '<td><a href="'.$page.'&page=' . ($_SESSION["page"]-1) . '">< </a></td>';
			} else {
				echo '<td class="nolink"><</td>';
			}
			
			for($i=$start_page;$i<=$end_page;$i++) {
				if($i==$end_page) $dash = "";	else $dash = "-&nbsp";	
				if ($i == func_getPage()) {
					echo '<td class="current"><div>'.$i.'</div></td>';
				} else {
									
					if(strrpos($page,"?")===FALSE){
						echo '<td><a href="' . $page . '?page=' . $i . '">'.$i.'</a></td>';
					}else{
						echo '<td><a href="' . $page . '&page=' . $i . '">'.$i.'</a></td>';
					}
				}
			}
			
			if (func_getPage() < func_getTotalPage() && func_getPage() != func_getTotalPage()) {
				echo '<td><a href="'.$page.'&page=' . (func_getPage()+1).'">></a></td>';
			} else {
				echo '<td class="nolink">></td>';
			}
			echo "</tr></table>";
		}
	}
	/*function func_getPaging_2($page,$get=true) {
		if ($get) $page = getURL($page);
		if (func_getTotalPage() > 10) {
			if (func_getTotalPage() - func_getPage() <= 5 ) {
				$start_page = func_getPage() - (10 - ((func_getTotalPage() - func_getPage()) + 1));
				$end_page = func_getTotalPage();
			} else {
				if (func_getPage() - 4 <= 1 ) {
					$start_page = 1;
					$end_page = 10;
				} else {
					$start_page = func_getPage() - 4;
					$end_page = func_getPage() + 5;
				}
			}
		} else {
			$start_page = 1;
			$end_page = func_getTotalPage();
		}

		if (func_getTotalPage() > 0 ) {
			if (func_getPage() > 1 && func_getPage() != 1) { 
				echo '<a href="'.$page.'&page=' . ($_SESSION["page"]-1) . '" style="margin-right:20px;"><img src="img/left_arrow.png" align="absmiddle"></a>';
			} else {
				echo '<img src="img/left_arrow.png" align="absmiddle" style="margin-right:20px;">';
			}
			
			echo '&nbsp;';

			for($i=$start_page;$i<=$end_page;$i++) {
				if($i==$end_page) $dash = "";	else $dash = "-&nbsp";	
				if ($i == func_getPage()) {
					echo '<b>'.$i.'</b>&nbsp;'.$dash;
				} else {
									
					if(strrpos($page,"?")===FALSE){
						echo '<a href="' . $page . '?page=' . $i . '" class="pageNo">'.$i.'</a>&nbsp;'.$dash;
					}else{
						echo '<a href="' . $page . '&page=' . $i . '" class="pageNo">'.$i.'</a>&nbsp;'.$dash;
					}
				}
			}
			
		    if (func_getPage() < func_getTotalPage() && func_getPage() != func_getTotalPage()) {
					echo '<a href="'.$page.'&page=' . (func_getPage()+1).'" style="margin-left:20px;"><img src="img/right_arrow.png" align="absmiddle"></a>';
		    } else {
					echo '<img src="img/right_arrow.png" align="absmiddle" style="margin-left:20px;">';
			}
		}
	}*/
?>