<template>
    <div>
        <div class="_content">
            <div class="container">
                <div class="row">

                    <!-- Left section -->
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="_advertise_card _mar_b30">
                            <!-- Step one -->
                            <p class="_advertise_Sub_title _3title"><i class="fas fa-user"></i> Add Information</p>


                            <div class="_advertise_step_form">
                                <Form>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.type_id">
                                                <Select v-model="form.type_id" multiple filterable  placeholder="Select your type">
                                                    <Option v-for="item in types" :value="item.id" :key="item.id">{{ item.type_name }}</Option>
                                                </Select>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.age_restricted">
                                                <Select v-model="form.age_restricted" placeholder="Select age restriction">
                                                    <Option value="YES" label="Yes">
                                                        <span>Yes</span>
                                                    </Option>
                                                    <Option value="NO" label="No">
                                                        <span>No</span>
                                                    </Option>
                                                </Select>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.identifier">
                                                <Input v-model="form.identifier" @keyup.native="error.identifier=''" type="text" placeholder="Please enter unique identifier."/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.action">
                                                <Input v-model="form.action" @keyup.native="error.action=''" type="text" placeholder="Info name"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.challenge">
                                                <Input v-model="form.challenge" @keyup.native="error.challenge=''" type="text" placeholder="Challenge"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.address">
                                                <Input v-model="form.address" @keyup.native="error.address=''" type="text" placeholder="Address"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.phone">
                                                <Input v-model="form.phone" @keyup.native="error.phone=''" type="text" placeholder="Phone"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.food_type">
                                                <Input v-model="form.food_type" @keyup.native="error.food_type=''" type="text" placeholder="Food type"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.description">
                                                <Input v-model="form.description" @keyup.native="error.description=''" type="text" placeholder="Description"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.website">
                                                <Input v-model="form.website" @keyup.native="error.website=''" type="text" placeholder="Website"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.star_rating">
                                                <Input v-model="form.star_rating" @keyup.native="error.star_rating=''" type="text" placeholder="Star rating"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.google_ratings">
                                                <Input v-model="form.google_ratings" @keyup.native="error.google_ratings=''" type="text" placeholder="Google rating"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.business_name">
                                                <Input v-model="form.business_name" @keyup.native="error.business_name=''" type="text" placeholder="Business name"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.city">
                                                <Input v-model="form.city" @keyup.native="error.city=''" type="text" placeholder="City"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.state">
                                                <Input v-model="form.state" @keyup.native="error.state=''" type="text" placeholder="State"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.zip_code">
                                                <Input v-model="form.zip_code" @keyup.native="error.zip_code=''" type="text" placeholder="Zip code"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.country">
                                                <Input v-model="form.country" @keyup.native="error.country=''" type="text" placeholder="Country"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.geo_tag">
                                                <Input v-model="form.geo_tag" @keyup.native="error.geo_tag=''" type="text" placeholder="Geo tag"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.event_date">
                                                <DatePicker type="date" placement="bottom-end" v-model="form.start_date" placeholder="Select event start date" style="width: 100%"></DatePicker>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.event_date">
                                                <DatePicker type="date" placement="bottom-end" v-model="form.end_date" placeholder="Select event end date" style="width: 100%"></DatePicker>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.geo_link">
                                                <Input v-model="form.geo_link" @keyup.native="error.geo_link=''" type="text" placeholder="Geo link"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.other_address_note">
                                                <Input v-model="form.other_address_note" @keyup.native="error.other_address_note=''" type="text" placeholder="Other address note"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.length">
                                                <Input v-model="form.length" @keyup.native="error.length=''" type="text" placeholder="Length"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.elevation_gain">
                                                <Input v-model="form.elevation_gain" @keyup.native="error.elevation_gain=''" type="text" placeholder="Elevation gain"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.social_media">
                                                <Input v-model="form.social_media" @keyup.native="error.social_media=''" type="text" placeholder="Social media"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.usa_ranking_elevation">
                                                <Input v-model="form.usa_ranking_elevation" @keyup.native="error.usa_ranking_elevation=''" type="text" placeholder="Usa ranking elevation"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem>
                                                <Input v-model="form.state_ranking_elevation" type="text" placeholder="State ranking elevation"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem>
                                                <Input v-model="form.world_ranking_elevation" type="text" placeholder="World ranking elevation"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem>
                                                <Input v-model="form.state_ranking_prominence" type="text" placeholder="State ranking elevation"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.usa_ranking_prominence">
                                                <Input v-model="form.usa_ranking_prominence" @keyup.native="error.usa_ranking_prominence=''" type="text" placeholder="Usa ranking prominence"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.facebook_link">
                                                <Input v-model="form.facebook_link" @keyup.native="error.facebook_link=''" type="text" placeholder="Facebook link"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.secondary_video">
                                                <Input v-model="form.secondary_video" @keyup.native="error.secondary_video=''" type="text" placeholder="Secondary video"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.instagram_link">
                                                <Input v-model="form.instagram_link" @keyup.native="error.instagram_link=''" type="text" placeholder="Instagram link"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.difficult_level">
                                                <Input v-model="form.difficult_level" @keyup.native="error.difficult_level=''" type="text" placeholder="Difficult level"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.tower_height">
                                                <Input v-model="form.tower_height" @keyup.native="error.tower_height=''" type="text" placeholder="Tower height"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.focal_point">
                                                <Input v-model="form.focal_point" @keyup.native="error.focal_point=''" type="text" placeholder="Focal point"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.main_pic">
                                                <Input v-model="form.main_pic" @keyup.native="error.main_pic=''" type="text" placeholder="Main picture"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.picture_one">
                                                <Input v-model="form.picture_one" @keyup.native="error.picture_one=''" type="text" placeholder="Picture one"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.picture_two">
                                                <Input v-model="form.picture_two" @keyup.native="error.picture_two=''" type="text" placeholder="Picture two"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.picture_three">
                                                <Input v-model="form.picture_three" @keyup.native="error.picture_three=''" type="text" placeholder="Picture Three"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.main_video">
                                                <Input v-model="form.main_video" @keyup.native="error.main_video=''" type="text" placeholder="Main video"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.badge_award_one">
                                                <Input v-model="form.badge_award_one" @keyup.native="error.badge_award_one=''" type="text" placeholder="Badge award one"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.badge_award_two">
                                                <Input v-model="form.badge_award_two" @keyup.native="error.badge_award_two=''" type="text" placeholder="Badge award two"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.badge_award_three">
                                                <Input v-model="form.badge_award_three" @keyup.native="error.badge_award_three=''" type="text" placeholder="Badge award three"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.badge_award_four">
                                                <Input v-model="form.badge_award_four" @keyup.native="error.badge_award_four=''" type="text" placeholder="Badge award four"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <FormItem :error="error.badge_award_five">
                                                <Input v-model="form.badge_award_five" @keyup.native="error.badge_award_five=''" type="text" placeholder="Badge award five"/>
                                            </FormItem>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="row" style="margin-bottom: 20px;">

                                                <div v-for="(item, i) in form.parent" :key="i" class="col-md-6 col-lg-6">

                                                    <h2>Parent {{i + 1}}</h2>
                                                    <div class="col-md-12">
                                                        <FormItem :error="error.category_id">
                                                            <Select @on-change="handleSelect1(item, i)" v-model="item.category_id" filterable placeholder="Select your category">
                                                                <Option v-for="cat in categories" :value="cat.id" :key="cat.id">{{ cat.cat_name }}</Option>
                                                            </Select>
                                                        </FormItem>
                                                    </div>

                                                    <span v-for="(under_sub, sub_index) in item.subcategory" :key="sub_index">
                                                        <div class="col-md-12">
                                                            <FormItem :error="error.subcategory_id">
                                                                <Select @on-change="handleSelect2(under_sub, sub_index, i)" v-model="under_sub.subcategory_id" filterable placeholder="Select your subcategory">
                                                                    <Option v-for="subcat in item.subcategories" :value="subcat.id" :key="subcat.id">{{ subcat.subcat_name }}</Option>
                                                                </Select>
                                                            </FormItem>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <FormItem :error="error.sub_subcategory_id">
                                                                <Select v-model="under_sub.sub_subcategory_id" multiple filterable placeholder="Select your sub-subcategory">
                                                                    <Option v-for="sub2 in under_sub.subSubcategories" :value="sub2.id" :key="sub2.id">{{ sub2.sub_subcat_name }}</Option>
                                                                </Select>
                                                            </FormItem>
                                                        </div>
                                                        <!-- <span v-if="under_sub.subcategory_id">
                                                             <p v-if="lastIndexSub == sub_index && sub_index < 1" style="cursor:pointer;font-weight:bold;" @click="addSub(i)">Add Subcategory</p> <br>
                                                        </span>
                                                        <p v-if="lastIndexSub == sub_index  && sub_index > 0" style="cursor:pointer;font-weight:bold;" @click="removeSub(i, sub_index)">Remove Subcategory</p><br/> -->
                                                    </span>

                                                    <span>
                                                       <Button v-if="lastIndex == i"  @click.native="addParent(i)">Add new</Button>
                                                    </span>

                                                    <Button v-if="form.parent.length"  @click.native="removeParent(i)">Cancel</Button> <br><br>
                                                </div> <br><br>

                                             <span>
                                                <Button v-if="form.parent.length == 0"  @click.native="addnewParent">Add new parent</Button> <br><br>
                                             </span>
                                            </div>


                                        </div>


                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="_advertise_step_button">
                                                <Button @click.native="addInfo" :loading="isLoading" :disabled="isLoading" class="_btn1 _btn_150" style="padding-top:7px !important;padding-bottom:7px !important;">{{ isLoading ? 'Please wait . . .' : 'Save Changes'}}</Button>
                                            </div>
                                        </div>

                                    </div>
                                </Form>
                            </div>
                            <!-- Step one -->
                        </div>
                    </div>
                    <!-- Left section -->

                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
	data(){
		return{
            types:[],
            categories:[],
			createModal: false,
			isLoading:false,
            lastIndex:4,
            lastIndexSub:1,
			form:{

                identifier:'',
                action:'',
                challenge:'',
                address:'',
                phone:'',
                food_type:'',
                description:'',
                website:'',
                star_rating:'',
                google_ratings:'',

                parent:[
                    {category_id:0, subcategories:[], subcategory:[ {subcategory_id:0, sub_subcategory_id:[], subSubcategories:[]}, {subcategory_id:0, sub_subcategory_id:[], subSubcategories:[]} ] },
                    {category_id:0, subcategories:[], subcategory:[ {subcategory_id:0, sub_subcategory_id:[], subSubcategories:[]}, {subcategory_id:0, sub_subcategory_id:[], subSubcategories:[]} ] },
                    {category_id:0, subcategories:[], subcategory:[ {subcategory_id:0, sub_subcategory_id:[], subSubcategories:[]}, {subcategory_id:0, sub_subcategory_id:[], subSubcategories:[]} ] },
                    {category_id:0, subcategories:[], subcategory:[ {subcategory_id:0, sub_subcategory_id:[], subSubcategories:[]}, {subcategory_id:0, sub_subcategory_id:[], subSubcategories:[]} ] },
                    {category_id:0, subcategories:[], subcategory:[ {subcategory_id:0, sub_subcategory_id:[], subSubcategories:[]}, {subcategory_id:0, sub_subcategory_id:[], subSubcategories:[]} ] }
                ],
                type_id:[],
                age_restricted:'',
                business_name:'',
                city:'',
                state:'',
                zip_code:'',
                country:'',
                start_date:null,
                end_date:null,
                geo_tag:'',
                geo_link:'',
                other_address_note:'',
                length:'',
                elevation_gain:'',
                social_media:'',
                state_ranking_elevation:'',
                world_ranking_elevation:'',
                state_ranking_prominence:'',
                usa_ranking_elevation:'',
                usa_ranking_prominence:'',
                facebook_link:'',
                secondary_video:'',
                instagram_link:'',
                difficult_level:'',
                tower_height:'',
                focal_point:'',
                main_pic:'',
                picture_one:'',
                picture_two:'',
                picture_three:'',
                main_video:'',
                badge_award_one:'',
                badge_award_two:'',
                badge_award_three:'',
                badge_award_four:'',
                badge_award_five:'',
			},
			error:{
                action:'',
                challenge:'',
                age_restricted:'',
                type_id:'',
                identifier:'',
			},


		}
	},

	methods:{
        addParent(i){
            this.lastIndex =i + 1;
            let ob = {category_id:0, subcategories:[], subcategory:[ {subcategory_id:0, sub_subcategory_id:[], subSubcategories:[]}, {subcategory_id:0, sub_subcategory_id:[], subSubcategories:[]} ] }
            this.form.parent.push(ob)
        },
        addnewParent(){
            this.lastIndex = 0;
            let ob = {category_id:0, subcategories:[], subcategory:[ {subcategory_id:0, sub_subcategory_id:[], subSubcategories:[]}, {subcategory_id:0, sub_subcategory_id:[], subSubcategories:[]} ] }
            this.form.parent.push(ob)
        },
        addSub(i){
            this.lastIndexSub =i + 1;
            let ob = {subcategory_id:0, sub_subcategory_id:[], subSubcategories:[]}
            this.form.parent[i].subcategory.push(ob);
        },
        removeParent(i){
            this.form.parent.splice(i,1)
            this.lastIndex --;
        },
        removeSub(i, sub_index){
            this.form.parent[i].subcategory.splice(sub_index,1)
            this.lastIndexSub --;
        },
		async addInfo() {
			this.clearDataError();

			let flag = 1
			if(!this.form.action  || this.form.action.trim()=='' || this.form.action==null){
				this.error.action ='Info name is required!'
				flag = 0
			}
			if(!this.form.challenge  || this.form.challenge==null){
				this.error.challenge ='Challenge is required!'
				flag = 0
			}
			if(!this.form.age_restricted  || this.form.age_restricted==''){
				this.error.age_restricted ='Age restriction is required!'
				flag = 0
			}
			if(!this.form.identifier  || this.form.identifier==''){
				this.error.identifier ='Identifier field is required!'
				flag = 0
			}
			// if(!this.form.type_id  || this.form.type_id==''){
			// 	this.error.type_id ='Type is required!'
			// 	flag = 0
			// }

			if(flag==0) return

			this.isLoading = true;

            this.form.start_date = this.form.start_date ? this.formateDate(this.form.start_date) :null;
            this.form.end_date = this.form.end_date ? this.formateDate(this.form.end_date) :null;

			const res = await this.callApi('post','/category/addInformation', this.form)

			if(res.status==200 || res.status==201){
                window.location.reload();
				this.s("Info created successfully!");
				// this.clearData()
			}
			this.isLoading = false;

		},
        formateDate(date){
             var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        },
        async handleSelect1(item, i){
            this.form.parent[i].subcategory[0].sub_subcategory_id = [];
            this.form.parent[i].subcategory[1].sub_subcategory_id = [];
           this.getSubcategies(item.category_id, i)
        },
        async handleSelect2(item, sub_index, i){
            this.form.parent[i].subcategory[sub_index].sub_subcategory_id = [];
            this.getSubsubcategies(item.subcategory_id, sub_index, i);
        },
        async handleSelect3(data){
            // this.getSubsubcategies(this.form.subcategory_id)
        },
        async getTypes(){
            const res = await this.callApi('get', '/category/getTypes')
            if(res.status == 200){
                this.types = res.data;
            }
        },
        async getCategories(){
            const res = await this.callApi('get', '/category/getCategories')
            if(res.status == 200){
                this.categories = res.data;
            }
        },
        async getSubcategies(id, i){
            const res = await this.callApi('get', `/category/getSubcategories?cat_id=${id}`)
            if(res.status == 200){
                this.form.parent[i].subcategories = res.data;
            }
        },
        async getSubsubcategies(id, under_sub, i){
            const res = await this.callApi('get', `/category/getSubsubcategories?subcat_id=${id}`)
            if(res.status == 200){
                this.form.parent[i].subcategory[under_sub].subSubcategories = res.data;
            }
        },
		clearDataError() {
			this.error = {
                action:'',
                challenge:'',
                address:'',
                phone:'',
                food_type:'',
                description:'',
                website:'',
                star_rating:'',
                google_ratings:'',
                category_id:'',
                subcategory_id:'',
                sub_subcategory_id:'',
		   }
    	},
		clearData() {
			this.form = {
                action:'',
                challenge:'',
                address:'',
                phone:'',
                food_type:'',
                description:'',
                website:'',
                star_rating:'',
                google_ratings:'',
                category_id:'',
                subcategory_id:'',
                sub_subcategory_id:'',
			}
		},



	},

    async created(){
        // this.lastIndex = this.form.parent.length;
        this.getTypes();
        this.getCategories();
    }






}
</script>
<style scoped>
.ivu-btn[disabled]{
    background: #ce6a6a;
}

</style>
