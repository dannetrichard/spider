<?php

use Illuminate\Database\Seeder;

use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $cat;
    private $cid;
    private $json; 
    
    public function run()
    {
    
				//$url = 'https://upload.taobao.com/auction/json/reload_cats.htm?customId=&fenxiaoProduct=&sid=16'; 
				$this->cat[] = ['tb_category_id' => 16,'name' => '女装/女士精品','parent_id'=> 0,];
				$this->cid = 16;
				$this->json = '[{"inpro":0,"pName":"类目","data":[{"data":[{"spell":"bsq","name":"半身裙","spuid":0,"leaf":2,"sid":"1623","status":0},{"spell":"bxdd","name":"背心吊带","spuid":0,"leaf":2,"sid":"121412004","status":0}],"name":"b"},{"data":[{"spell":"cs","name":"衬衫","spuid":0,"leaf":2,"sid":"162104","status":0}],"name":"c"},{"data":[{"spell":"dwt","name":"短外套","spuid":0,"leaf":2,"sid":"50011277","status":0},{"spell":"dmnz","name":"大码女装","spuid":0,"leaf":2,"sid":"1629","status":0}],"name":"d"},{"data":[{"spell":"fy","name":"风衣","spuid":0,"leaf":2,"sid":"50008901","status":0}],"name":"f"},{"data":[{"spell":"hsother_typeqpother_typelf","name":"婚纱/旗袍/礼服","spuid":0,"leaf":0,"sid":"50011404","status":0}],"name":"h"},{"data":[{"spell":"kz","name":"裤子","spuid":0,"leaf":0,"sid":"1622","status":0}],"name":"k"},{"data":[{"spell":"lyq","name":"连衣裙","spuid":0,"leaf":2,"sid":"50010850","status":0},{"spell":"lssother_typexfs","name":"蕾丝衫/雪纺衫","spuid":0,"leaf":2,"sid":"162116","status":0}],"name":"l"},{"data":[{"spell":"mj","name":"马夹","spuid":0,"leaf":2,"sid":"50013196","status":0},{"spell":"mzzs","name":"毛针织衫","spuid":0,"leaf":2,"sid":"50000697","status":0},{"spell":"my","name":"毛衣","spuid":0,"leaf":2,"sid":"162103","status":0},{"spell":"mnwt","name":"毛呢外套","spuid":0,"leaf":2,"sid":"50013194","status":0},{"spell":"myother_typemf","name":"棉衣/棉服","spuid":0,"leaf":2,"sid":"50008900","status":0},{"spell":"mx","name":"抹胸","spuid":0,"leaf":2,"sid":"121434004","status":0}],"name":"m"},{"data":[{"spell":"nzk","name":"牛仔裤","spuid":0,"leaf":2,"sid":"162205","status":0}],"name":"n"},{"data":[{"spell":"py","name":"皮衣","spuid":0,"leaf":2,"sid":"50008904","status":0},{"spell":"pc","name":"皮草","spuid":0,"leaf":2,"sid":"50008905","status":0}],"name":"p"},{"data":[{"spell":"tx","name":"T恤","spuid":0,"leaf":2,"sid":"50000671","status":0},{"spell":"tzother_typexsxfother_typegzzf","name":"套装/学生校服/工作制服","spuid":0,"leaf":0,"sid":"1624","status":0},{"spell":"tzother_typemzfzother_typewtfz","name":"唐装/民族服装/舞台服装","spuid":0,"leaf":0,"sid":"50008906","status":0}],"name":"t"},{"data":[{"spell":"wyother_typers","name":"卫衣/绒衫","spuid":0,"leaf":2,"sid":"50008898","status":0}],"name":"w"},{"data":[{"spell":"xz","name":"西装","spuid":0,"leaf":2,"sid":"50008897","status":0}],"name":"x"},{"data":[{"spell":"yrf","name":"羽绒服","spuid":0,"leaf":2,"sid":"50008899","status":0}],"name":"y"},{"data":[{"spell":"zlnnz","name":"中老年女装","spuid":0,"leaf":2,"sid":"50000852","status":0}],"name":"z"}],"shopType":0,"type":0,"sid":"0","isBrand":0}] ';
				$this->sid();
				$this->cid = 50011404;
				$this->json = '[{"inpro":0,"pName":"类目","data":[{"data":[{"spell":"hs","name":"婚纱","spuid":0,"leaf":2,"sid":"162701","status":0}],"name":"h"},{"data":[{"spell":"lfother_typewz","name":"礼服/晚装","spuid":0,"leaf":2,"sid":"162702","status":0}],"name":"l"},{"data":[{"spell":"qp","name":"旗袍","spuid":0,"leaf":2,"sid":"50005065","status":0}],"name":"q"}],"shopType":0,"type":0,"sid":"0","isBrand":0}] ';
				$this->sid();
				$this->cid = 1622;
				$this->json = '[{"inpro":0,"pName":"类目","data":[{"data":[{"spell":"ddk","name":"打底裤","spuid":0,"leaf":2,"sid":"50007068","status":0}],"name":"d"},{"data":[{"spell":"mkother_typeyrk","name":"棉裤/羽绒裤","spuid":0,"leaf":1,"sid":"50026651","status":0}],"name":"m"},{"data":[{"spell":"xxk","name":"休闲裤","spuid":0,"leaf":2,"sid":"162201","status":0},{"spell":"xzkother_typezzk","name":"西装裤/正装裤","spuid":0,"leaf":2,"sid":"50022566","status":0}],"name":"x"}],"shopType":0,"type":0,"sid":"0","isBrand":0}] ';
				$this->sid();
				$this->cid = 1624;
				$this->json = '[{"inpro":0,"pName":"类目","data":[{"data":[{"spell":"jdgzzf","name":"酒店工作制服","spuid":0,"leaf":2,"sid":"50011412","status":0}],"name":"j"},{"data":[{"spell":"qttz","name":"其它套装","spuid":0,"leaf":2,"sid":"162403","status":0},{"spell":"qtzf","name":"其它制服","spuid":0,"leaf":2,"sid":"50011413","status":0}],"name":"q"},{"data":[{"spell":"sstz","name":"时尚套装","spuid":0,"leaf":2,"sid":"123216004","status":0}],"name":"s"},{"data":[{"spell":"xsxf","name":"学生校服","spuid":0,"leaf":2,"sid":"50008903","status":0},{"spell":"xxydtz","name":"休闲运动套装","spuid":0,"leaf":2,"sid":"162404","status":0}],"name":"x"},{"data":[{"spell":"yhzf","name":"医护制服","spuid":0,"leaf":2,"sid":"50011411","status":0}],"name":"y"},{"data":[{"spell":"zynqtz","name":"职业女裙套装","spuid":0,"leaf":2,"sid":"162401","status":0},{"spell":"zynktz","name":"职业女裤套装","spuid":0,"leaf":2,"sid":"162402","status":0}],"name":"z"}],"shopType":0,"type":0,"sid":"0","isBrand":0}]  ';
				$this->sid();
				$this->cid = 50008906;
				$this->json = '[{"inpro":0,"pName":"类目","data":[{"data":[{"spell":"mzfzother_typewtz","name":"民族服装/舞台装","spuid":0,"leaf":2,"sid":"162703","status":0}],"name":"m"},{"data":[{"spell":"tzother_typezsfz","name":"唐装/中式服装","spuid":0,"leaf":0,"sid":"1636","status":0}],"name":"t"}],"shopType":0,"type":0,"sid":"0","isBrand":0}]  ';
				$this->sid();
    		
				foreach($this->cat as $v){
					Category::create($v);
				}
    }   
	public function sid(){
		$data = json_decode($this->json,true);
		foreach($data[0]['data'] as $v){
			foreach($v['data'] as $v1){
					$this->cat[] = ['tb_category_id' => $v1['sid'],'name' => $v1['name'],'parent_id'=> $this->cid,];
			}
		}
		
	}
}
