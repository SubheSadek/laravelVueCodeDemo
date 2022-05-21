<template>
	<div>
		<div class="_main_content">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12 _mar_b10">
					<Alert show-icon>
						<span style="font-weight:bold;"> Total Informations : {{infos.total}}</span>
						<template slot="desc">All Informations with search, create, edit and delete options.</template>
					</Alert>
				</div>
				<div class="col-12 col-md-12 col-lg-12">
					<div class="_box _b_radious3 _padd20">
						<div class="_1card_top _mar_b20">

							<div class="_1card_top_left">

								<div class="_1card_top_search">
									<!-- <Input @on-change="serchResetlt" v-model="str" suffix="ios-search" placeholder="Search Informations ..." /> -->
                                    <Input search enter-button="Search" @on-change="search = false" @on-search="serchResetlt" v-model="str" placeholder="Enter Info..." />
								</div>

							</div>
                            <div class="_1card_top_right">
                                <ul class="_1card_top_right_list">
                                    <li><template>
                                        <Button v-if="authInfo.role === 'SUPER_ADMIN'" @click.native="deleteAll" icon="md-add" type="error">Delete All informations (include categories, sub-categories & sub-subcategories)</Button>
                                        <Button to="/information/add" icon="md-add" type="primary">Add New</Button>
                                    </template></li>
                                </ul>
                            </div>

						</div>
						<div class="_table_responsive">
							<Table class="" border :columns="columns1" :data="str && search ? searchInfo : infos.data">
									<template slot-scope="{row}" slot="info_name">
										<p>{{row.action}}</p>
									</template>
									<template slot-scope="{row}" slot="challenge">
                                        <p>{{row.challenge}}</p>
									</template>
									<template slot-scope="{row}" slot="address">
                                        <p>{{row.address}}</p>
									</template>
									<template slot-scope="{row}" slot="phone">
                                        <p>{{row.phone}}</p>
									</template>
									<template slot-scope="{row}" slot="food_type">
                                        <p>{{row.food_type}}</p>
									</template>
									<template slot-scope="{row}" slot="start_date">
                                        <p>{{row.start_date}}</p>
									</template>
									<template slot-scope="{row}" slot="end_date">
                                        <p>{{row.end_date}}</p>
									</template>
									<template slot-scope="{row}" slot="description">
                                        <p>{{row.description | str_limit(50)}} <span v-if="row.description" style="font-weight:bold;color:#53a4f9;cursor:pointer;" @click="viewMore(row.description)">see more</span></p>
									</template>
									<template slot-scope="{row}" slot="website">
                                        <p>{{row.website}}</p>
									</template>
									<template slot-scope="{row}" slot="star_rating">
                                        <p>{{row.star_rating}}</p>
									</template>
									<template slot-scope="{row}" slot="google_rating">
                                        <p>{{row.action}}</p>
									</template>

									<template slot-scope="{row}" slot="parent">
                                        <p v-if="row.category.length">
                                            <span style="margin-right: 2px;" v-for="(item,i) in row.category" :key="i">
                                                <Button @click.native="showCat(item)" size="small">{{item.cat? item.cat.cat_name : ''}}</Button>
                                            </span>
                                        </p>
									</template>

									<template slot-scope="{row, index }" slot="action">
                                        <p>
										    <Button :to="`/information/edit/${row.id}`" icon="ios-create-outline" type="primary" size="small" >Edit</Button>
										    <Button icon="ios-trash-outline" type="error" size="small" @click="deleteCategory(row, index)">Delete</Button>
                                        </p>
									</template>
							</Table>
						</div>
						<div class="_pagination _padd_t20">
                            <p v-if="str && search && (searchInfo.length == limit || searchInfo.length > limit)">
                                <Button :loading="isSearch" :disabled="isSearch" icon="md-add" @click.native="getSearchInfo(true)" type="primary">View More Info</Button>
                            </p>
                            <p v-else-if="!str || !search">
                                <Page :total="infos.total"  show-sizer :page-size-opts="pageOption" @on-page-size-change="getSizeChange"  @on-change="paginateDataInfo" />
                            </p>

						</div>
					</div>
				</div>
			</div>
		</div>

        <Modal v-model="showCatModal" draggable  class-name="vertical-center-modal" scrollable title="Category">
			<div class="_login_form">
			  <Form>
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem>
                                <p>Category :</p>
								<Input v-model="category.cat_name" readonly :border="false"  size="large" type="text" placeholder="Category name"/>
							</FormItem>
							<FormItem>
                                <p>Subcategory :</p>
                                <span v-for="(sub, i) in category.subcategory" :key="i">
                                   <Input v-model="sub.subcat_name" readonly :border="false"  size="large" type="text"/>

                                   <FormItem>
                                        <p>Sub-subcategory :</p>
                                        <span v-for="(sub_sub, sub_index) in sub.sub_subcategory" :key="sub_index">
                                        <Input v-model="sub_sub.sub_subcat_name" readonly :border="false"  size="large" type="text"/>
                                        </span>
                                    </FormItem>
                                </span>

							</FormItem>

						</div>
					</div>
				</Form>
			</div>
			 <div slot="footer">
				<Button type="error" icon ="md-close" @click="showCatModal = false">Close</Button>
			</div>
		</Modal>

        <Modal v-model="seeMoreModal" draggable  class-name="vertical-center-modal" scrollable title="Details">
			<div class="_login_form">
			  <Form>
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">

							<FormItem>
								<Input :rows="5" v-model="seemoreData" readonly :border="false"  size="large" type="textarea" placeholder="Category name"/>
							</FormItem>

						</div>
					</div>
				</Form>
			</div>
			 <div slot="footer">
				<Button type="error" icon ="md-close" @click="seeMoreModal = false">Close</Button>
			</div>
		</Modal>

	</div>
</template>

<script>

import _ from 'lodash';

export default {

	components: {
    },
	data () {
		return {
            infos:[],
            searchInfo:[],
            search: false,
			isLoading:false,
            isSearch:false,
            showCatModal:false,
            seeMoreModal:false,
            seemoreData:'',
            category:{
                cat_name: '',
                subcateogry:[],
                sub_subcategory:[],
            },
			pageOption:[5,10,15,20],
			str:'',
			page:1,
			perPage:10,
            limit:15,


			datacollection: null,
			columns1: [
				 {
                    title: 'Sl.',
                    width: 150,
					type:'index',
                    align: 'center',

					indexMethod: (row) => {
                        return (row._index + 1) + (this.perPage * this.page) - this.perPage;
                    }
                },

				{
					title: 'Info name',
					slot: 'info_name',
					width:200,
				},
				{
					title: 'Challenge',
					width:500,
					slot: 'challenge'
				},
				{
					title: 'Address',
					width:500,
					slot: 'address'
				},
				{
					title: 'Phone',
					width:200,
					slot: 'phone'
				},
				{
					title: 'Food Type',
					width:200,
					slot: 'food_type'
				},

				{
					title: 'Event Start Date',
					width:200,
					slot: 'start_date'
				},
				{
					title: 'Event End Date',
					width:200,
					slot: 'start_date'
				},
				{
					title: 'Description',
					width:500,
					slot: 'description'
				},
				{
					title: 'Website',
					width:350,
					slot: 'website'
				},
				{
					title: 'Star Rating',
					width:200,
					slot: 'star_rating'
				},
				{
					title: 'Google Rating',
					width:200,
					slot: 'google_rating'
				},
				{
					title: 'Parent Category',
					width:500,
					slot: 'parent'
				},
				{
					title: 'Action',
                    minWidth: 350,
                    align: 'center',
					slot: 'action',
				},

			]
		}
	},

	methods: {

    async deleteAll(){
        this.$Modal.confirm({
            title: 'Warning',
            content: '<p>Are you sure to delete all this informations inclued categories, subcategories, sub-subcategories ?</p>',
            onOk: async() => {
                const res = await this.callApi('post',`/category/deleteAllInfo/`)

                if(res.status == 200){
                    this.s('Information deleted successfully !')
                    window.location.reload();
                }
            },

            onCancel: () => {

            }
        });

    },
    async viewMore(data){
        this.seeMoreModal=true;
        this.seemoreData = data;
    },
    async showCat(item){
        const res = await this.callApi('get', `/category/challengCategory?id=${item.id}`)
		if(res.status==200){
			this.category = res.data;
            this.showCatModal = true;
		}
    },
	async allinfos(){
		const res = await this.callApi('get', `/category/getAllInfo?page=${this.page}&perPage=${this.perPage}&str=${this.str}`)
			if(res.status==200){
				this.infos = res.data;
			}
	},
    serchResetlt(){
        if(this.str ==null || this.str == ''){
            this.i('Please, enter some text!');
            return;
        }
        this.getSearchInfo(null);
        this.search = true;
    },

    async getSearchInfo(isLastId){

        let infoLength = this.searchInfo.length;
        let lastId = infoLength && isLastId ? this.searchInfo[this.searchInfo.length-1].id : null;
        this.isSearch = true;
        const res = await this.callApi('get', `/category/searchInfo?str=${this.str}&limit=${this.limit}&lastid=${lastId}`)
			if(res.status==200){
                let data = res.data;
                if(isLastId){
                    this.searchInfo.push(...data)
                }else{
                   this.searchInfo = data;
                }

			}
        this.isSearch = false;
    },
	// serchResetlt:_.debounce(function (){
	// 	this.perPage = 10
	// 	this.paginateDataInfo(1)
	// },200),

	getSizeChange(e){
		this.perPage =e
		this.paginateDataInfo(1)
	},
	paginateDataInfo(e){
	   this.page = e
		this.allinfos()
    },

    deleteCategory(inf, i){
	this.$Modal.confirm({
          title: 'Message',
          content: '<p>Are you sure to delete this information ?</p>',
          onOk: async() => {
                    let obj ={
						info_id: inf.id
					}
				const res = await this.callApi('post',`/category/deleteInformation/`, obj)

				if(res.status == 200){
					this.s('Information deleted successfully !')
					this.infos.data.splice(i, 1);
					this.infos.total--
				}
          },

          onCancel: () => {

          }
      });
    },




	},

	async created () {
		this.allinfos()
	}
}
</script>


<style scoped>
._1card_top_search .ivu-input-wrapper{
	width:130%;
}
</style>
