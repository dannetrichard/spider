<?php

namespace Dannetrichard\Spider;

require('Helpers.php');

use App\Category;
use App\Shop;
use App\Product;
use App\Sku;


class Spider
{
    public static function multiply($a, $b)
    {
        return $a * $b;
    }

    public function static refresh(){
        
        foreach (Product::cursor() as $product) {
                $detail = $this->wdetail($product->tb_product_id);  
                 if($detail){
                    $product_id = $this->product($detail); 
                 }   
        }
         
    }
    public static function index(){
                
        $shops = Shop::where('status','normal')->get();
        if($shops){
            foreach ($shops as $shop) {
     
                $items = $this->shop_item_search($shop->tb_shop_id);
                if($items){
                    foreach($items as $item){
                     
                        $detail = $this->wdetail($item['item_id']);  
                        if($detail){
                            $product_id = $this->product($detail); 
                        }   
                         
                        
                    }
                }
            }             
            
        }
    }
    

    public function shop_item_search($shopId='145530573'){
        
            $url = 'http://api.s.m.taobao.com/search.json?m=shopitemsearch&n=40&page=1&sort=oldstarts&shopId='.$shopId;
            
            $data = curl_array($url);
            
            $items = $data['itemsArray'];
            
            $totalPage = $data['totalPage'];
            
            if($totalPage  > 1){
                
                    for ($page=2; $page<=$totalPage; $page++) {
                        
                        $url = 'http://api.s.m.taobao.com/search.json?m=shopitemsearch&n=40&page='.$page.'&sort=oldstarts&shopId='.$shopId;
                        
                        $data = curl_array($url);
                        
                        $items = array_merge($items,$data['itemsArray']);
                        
                    }
                    
            }
            
            for($i=0;$i<count($items);$i++){   
                $items[$i] = array_only($items[$i],['item_id']);
            }
            
            if($items){
                $items = $this->valid($items);
            }       
            return $items;
    }
    
    public function valid($items,$limit = 30){
     
        foreach($items as $k => $v){
            if(Product::where('tb_product_id',$v['item_id'])->first() || $k==$limit){
                return array_slice($items,0,$k);
            }
        }

        return $items;  
    }    
    
    public function wdetail($id='555372768612'){
        
        $url = 'http://hws.m.taobao.com/cache/wdetail/5.0?id=' . $id;
		
		$detail = curl_array($url) ['data'];

        if (!isset($detail['itemInfoModel']['picsPath'])||!isset($detail['itemInfoModel']['sku'])||!isset($detail['skuModel']['skuProps'])||!isset($detail['props'])||str_contains($detail['itemInfoModel']['title'],['2016','2015'])) {
			return false;
		}

		$category = Category::where('tb_category_id', $detail['itemInfoModel']['categoryId'])->first();
		if(!$category){
		    return false;    
		}
		
		return $detail;
		
    }
    
    public function name_process($name){
			$name_moved = preg_replace('/( |　|	|	|\s|\n|\r|\t|2017)*/','', $name);	
			$dealer_price = 0;
			$limit_price = 0;
			$article_number ='';
			$owners = 0;
			$recommend = 0;
			$instock=0;
			$presale = 0;
			$presale_date = date("Y-m-d");
            
			//------------------货号、价格
			$regexs= [
									'#\d+([A-za-z]+\d+)(-p|\/p|p|-f|\/f|f)(\d*)#i',
									'#\d+([A-za-z]+\d+)(-p|\/p|p|-f|\/f|f) #i',
									'#\w+(-|\/)(([A-za-z]*\d+)|(\(.+\)))(-p|\/p|p|-f|\/f|f)(\d*)#i',
									'#([A-za-z]*\d+)(-p|\/p|p|-f|\/f|f)(\d*)#i',
									'#([A-za-z]*\d+)(-p|\/p|p|-f|\/f|f)(\d*)#i',
									'#p(\d+)#i',
									];

			if(preg_match($regexs[0], $name_moved, $matches)){
							$article_number = $matches[1];
							$dealer_price = $matches[3];
							$name_moved = preg_replace($regexs[0],'',$name_moved);
			}elseif(preg_match($regexs[1], $name_moved, $matches)){
							$article_number = $matches[1];
							$name_moved = preg_replace($regexs[1],'',$name_moved);
			}elseif(preg_match($regexs[2], $name_moved, $matches)){
							$article_number = $matches[2];
							$dealer_price = $matches[6];
							$name_moved = preg_replace($regexs[2],'',$name_moved);
			}elseif(preg_match($regexs[3], $name_moved, $matches)){
							$article_number = $matches[1];
							$dealer_price = $matches[3];
							$name_moved = preg_replace($regexs[3],'',$name_moved);
			}elseif(preg_match($regexs[4], $name_moved, $matches)){
							$dealer_price = $matches[2];
							$name_moved = preg_replace($regexs[4],'',$name_moved);
			}elseif(preg_match($regexs[5], $name_moved, $matches)){
							$dealer_price = $matches[1];
							$name_moved = preg_replace($regexs[5],'',$name_moved);
			}
			
					
            //------------------预售
			
			$regexs = [	'#(\d+)月(\d+)(号)*出货#',
									'#(\d+)(号|日)(出货|大货)(！|!)*#',
									'#提前出货(\d+)号#',
									];
			
			if(preg_match($regexs[0], $name_moved, $matches) && ($matches[1] == date('m') || $matches[1] == date('m') +1) && $matches[2]<=31){			   
				$presale = 1;
				$presale_date = date('Y').'-'.str_pad($matches[1],2,'0',STR_PAD_LEFT).'-'.str_pad($matches[2],2,'0',STR_PAD_LEFT);
				$name_moved = preg_replace($regexs[0],'',$name_moved);		
			}elseif(preg_match($regexs[1], $name_moved, $matches)&& $matches[1]<=31){
				$presale = 1;
				$presale_date = date('Y').'-'.date('m').'-'.str_pad($matches[1],2,'0',STR_PAD_LEFT);
				$name_moved = preg_replace($regexs[1],'',$name_moved);				
			}elseif(preg_match($regexs[2], $name_moved, $matches)&& $matches[1]<=31){
				$presale = 1;
				$presale_date = date('Y').'-'.date('m').'-'.str_pad($matches[1],2,'0',STR_PAD_LEFT);
				$name_moved = preg_replace($regexs[2],'',$name_moved);				
			}	
						
			if($presale==1&& strtotime(date("Y-m-d")) < strtotime($presale_date)){
			    $product['presale'] = $presale;			
			    $product['presale_date'] = $presale_date;				
			}			
			//------------------控价
			$regex = '#(控|控价|控价最低|价格不低于|售价不低于|卖价不低于|控价不能低于|严格控价不得低于|最低售价不得低于|最低价格|最低限价|限价|控价不低于|控价最低卖价)(\d+)(\+|元|块)*#';
			if(preg_match($regex, $name_moved, $matches)){
				$limit_price = $matches[2];
				$name_moved = preg_replace($regex,'',$name_moved);
			}				
			
			$name_moved = preg_replace('/(【|】|（|）|\(|\))*/','', $name_moved);
			//------------------实拍
			
			$regex = '#(模特)*实拍-*(！|!)*#';
			if(preg_match($regex, $name_moved, $matches)){
				$owners = 1;
				$name_moved = preg_replace($regex,'',$name_moved);		
			}				
			
			//------------------主推
			
			$regex = '#(大货主推款|大货主推|主推款|主推爆款|爆款主推|主推|爆款)(！|!)*#';   
			if(preg_match($regex, $name_moved, $matches)){
				$recommend = 1;
				$name_moved = preg_replace($regex,'',$name_moved);		
			}					

			//------------------现货
			
			$regex = '#大货已出(！|!)*|已出货|现货-*|大量现货#';
			if(preg_match($regex, $name_moved, $matches)){
				$instock = 1;
				$name_moved = preg_replace($regex,'',$name_moved);		
			}	
				
				
	      
			
            $product = ['name'=>$name_moved,
                        'instock'=>$instock,
                        'recommend'=>$recommend,
                        'owners'=>$owners,
                        'limit_price'=>$limit_price,
                        'dealer_price'=>$dealer_price,
                        'article_number'=>$article_number,
                        'presale'=>$presale,
                        'presale_date'=>$presale_date,
            ];

                


	        return $product;					      						    
    }
    
    public function desc($fullDescUrl){
            
            $output = curl_json($fullDescUrl);
            
            preg_match_all('/https?\:\/\/img.alicdn.com\/(.+?)(\.jpg|\.png|\.gif)/', $output, $match);
            
            if ($match[0] == null) {
			        $product['status'] = 1;
			        $product['desc'] = '';
		    } else {
			        
			        /*
			        foreach ($match[0] as $pic) {
			
							$img_info = getimagesize($pic);
	
							if ($img_info[0] > 400 && $img_info[1] > 400) {
										$pics[] = $pic;
							}	
	
		            }
		            */
		            $pics = $match[0];
			        $product['status'] = 2;
			        $product['desc'] = json_encode($pics, true);
		    }
            
            return $product;
    }
    
    public function created($id) {

		    $url = 'http://www.taodaxiang.com/shelf/index/get';
		    $post_data = array('pattern' => '1', 'wwid' => '', 'goodid' => $id, 'page' => '1');
		    $data = curl_array_post($url, $post_data);
		    $product['created'] = date("Y-m-d H:i:s", $data['data'][0]['create']);
		    return $product;
		    
    } 


    public function product($detail) {
   
		$apiStack_itemInfoModel = json_decode($detail['apiStack'][0]['value'], true) ['data']['itemInfoModel'];
		$itemInfoModel = $detail['itemInfoModel'];
		$props = $detail['props'];
		$skuModel = $detail['skuModel'];
		$seller = $detail['seller'];
		$rateInfo = $detail['rateInfo'];
		$descInfo = $detail['descInfo'];	
		//tb_product_id
		$product['tb_product_id'] = $itemInfoModel['itemId'];	
	    //echo '>>>'.$product['tb_product_id'].'>>>';
        //price \ discount_price
		if (isset($apiStack_itemInfoModel['priceUnits'][1])) {
			$product['price'] = $apiStack_itemInfoModel['priceUnits'][1]['price'];
		}else{
			$product['price'] = $apiStack_itemInfoModel['priceUnits'][0]['price'];
		}
		$product['discount_price'] = $apiStack_itemInfoModel['priceUnits'][0]['price'];
		
		if(str_contains($product['price'],'-')){
		    $product['price'] = explode('-',$product['price'])[0];
		}
		if(str_contains($product['discount_price'],'-')){
		    $product['discount_price'] = explode('-',$product['discount_price'])[0];
		}		
		
		
		//num \ sale_num \ collect_num \ rate_num
		$product['num'] = $apiStack_itemInfoModel['quantity'];
		$product['sale_num'] = $apiStack_itemInfoModel['totalSoldQuantity'];
		$product['collect_num'] = $itemInfoModel['favcount'];
		$product['rate_num'] = $rateInfo['rateCounts'];
				
		//location pic_url pics_url		
		$product['location'] = $itemInfoModel['location'];		
		$product['pic_url'] = $itemInfoModel['picsPath'][0];
		$product['pics_url'] = json_encode($itemInfoModel['picsPath'], true);
	
		//sku_props binds_str sale_props_str
		$product['sku_props'] = json_encode($skuModel['skuProps'], true);
	    $product['binds_str'] = '';
		$product['sale_props_str'] = '';


		foreach ($props as $k => $v) {
		
			if (strstr($v['name'], '颜色') || strstr($v['name'], '尺码') || strstr($v['name'], '尺寸')) {
				$product['sale_props_str'] = $product['sale_props_str'] . $v['name'] . ':' . $v['value'] . ';';
			} else {
				$product['binds_str'] = $product['binds_str'] . $v['name'] . ':' . $v['value'] . ';';
			}
		}		
	
		//category_id category_name		
		$product['tb_category_id'] = $itemInfoModel['categoryId'];
		$category = Category::where('tb_category_id', $itemInfoModel['categoryId'])->first();
		$product['category_id'] = $category->id;
		$product['category_name'] = $category->name;
		
		//tb_shop_id 
		$product['tb_shop_id'] = $seller['shopId'];
		$shop = Shop::where('tb_shop_id', $seller['shopId'])->first();
		$product['shop_id'] = $shop->id;
		$product['shop_name'] = $shop->name;
	
		//desc created name
		$product = array_merge($product,$this->desc($descInfo['fullDescUrl']));
		$product = array_merge($product,$this->created($itemInfoModel['itemId']));
		$product = array_merge($product,$this->name_process($itemInfoModel['title']));
		if($product['dealer_price']==''||$product['dealer_price']>$product['discount_price']){
			    $product['dealer_price']=0.00;
	    }	
		if($product['limit_price']==''||$product['limit_price']>$product['discount_price']){
			    $product['limit_price']=0.00;
	    }
		//seller_code
		$product['seller_code'] = $shop->name.'-'.$product['article_number'].'-P'.$product['dealer_price'];
		        
	
		//$id = Product::create($product)->id;
		$id = Product::updateOrCreate(['tb_product_id'=>$product['tb_product_id']],$product)->id;
		$this->sku($detail,$id);
        return $id;
            
	
	}   
	
    public function sku($detail,$product_id) {
		$skuModel = $detail['skuModel'];
		$ppathIdmap = array_flip($skuModel['ppathIdmap']);
		
		$apiStack = $detail['apiStack'];
		$data = json_decode($apiStack[0]['value'], true) ['data']['skuModel']['skus'];
		
		$itemInfoModel = $detail['itemInfoModel'];
        
       
		foreach($data as $k => $v){
		    //product_id tb_sku_id quantity discount_price price
		    $temp = ['tb_product_id'=>$itemInfoModel['itemId'],'product_id'=>$product_id,'tb_sku_id' => $k ,'quantity'=>$v['quantity']];
		     
		    $temp['discount_price'] = $v['priceUnits'][0]['price'];
		     
		    if (isset($v['priceUnits'][1])) {
				$temp['price'] = $v['priceUnits'][1]['price'];
			}else{
			    $temp['price'] = $v['priceUnits'][0]['price'];
			}
			
		    if(str_contains($temp['price'],'-')){
		        $temp['price'] = explode('-',$temp['price'])[0];
		    }
		    if(str_contains($temp['discount_price'],'-')){
		        $temp['discount_price'] = explode('-',$temp['discount_price'])[0];
		    }			
		    //properties_name
			$nn = '';
			$arr = explode(';', $ppathIdmap[$k]);
			foreach ($arr as $val) {
				$arr1 = explode(':', $val);
				foreach ($skuModel['skuProps'] as $k1 => $v1) {
					if ($arr1[0] == $v1['propId']) {
						foreach ($v1['values'] as $k2 => $v3) {
							if ($arr1[1] == $v3['valueId']) {
								$nn = $nn . $v3['name'] . ' ';
							}
						}
					}
				}
			}
			$temp['properties_name'] = trim($nn);	
			$sku[] = $temp;

		}
		
		if(isset($sku)){
		    foreach($sku as $v){
				//Sku::create($v);
			    Sku::updateOrCreate(['tb_sku_id'=>$v['tb_sku_id']],$v);
			}
	    }
		
		
    }	

}












	