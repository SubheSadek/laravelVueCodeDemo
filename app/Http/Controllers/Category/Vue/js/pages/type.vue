<template>
	<div>
		<div class="_main_content">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12 _mar_b10">
					<Alert show-icon>
						<span style="font-weight:bold;"> Total Information Types : {{types.total}}</span>
						<template slot="desc">All types with search, create, edit and delete options.</template>
					</Alert>
				</div>
				<div class="col-12 col-md-12 col-lg-12">
					<div class="_box _b_radious3 _padd20">
						<div class="_1card_top _mar_b20">

							<div class="_1card_top_left">

								<div class="_1card_top_search">
									<Input @on-change="serchResetlt" v-model="str" suffix="ios-search" placeholder="Search types by name ..." />
								</div>

							</div>
							<!--create-modal-start-->
							<addType :type="types"/>
							<!--create-modal-end-->

						</div>
						<div class="_table_responsive">
							<Table class="" border :columns="columns1" :data="types.data">
									<template slot-scope="{row}" slot="cat_name">
										<p>{{row.type_name}}</p>
									</template>
									<template slot-scope="{row, index }" slot="action">
                                        <p>
											<editType :type="row"/>
										    <Button icon="ios-trash-outline" type="error" size="small" @click="deleteType(row, index)">Delete</Button>
                                        </p>
									</template>
							</Table>
						</div>
						<div class="_pagination _padd_t20">
							<Page :total="types.total"  show-sizer :page-size-opts="pageOption" @on-page-size-change="getSizeChange"  @on-change="paginateDataInfo" />
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>

import _ from 'lodash';
import addType from '../../../../Category/Vue/js/components/type/addType'
import editType from '../../../../Category/Vue/js/components/type/editType'

export default {

	components: {
		addType,
		editType
	},
	data () {
		return {
            types:[],
			isLoading:false,
			pageOption:[5,10,15,20],
			str:'',
			page:1,
			perPage:10,


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
					title: 'Type name',
					slot: 'cat_name',
					width:400,
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
	async alltypes(){
		const res = await this.callApi('get', `/category/getAllTypes?page=${this.page}&perPage=${this.perPage}&str=${this.str}`)
			if(res.status==200){
				this.types = res.data;
			}
	},

	serchResetlt:_.debounce(function (){
		this.perPage = 10
		this.paginateDataInfo(1)
	},200),

	getSizeChange(e){
		this.perPage =e
		this.paginateDataInfo(1)
	},
	paginateDataInfo(e){
	   this.page = e
		this.alltypes()
    },

    deleteType(type, i){
	this.$Modal.confirm({
          title: 'Message',
          content: '<p>Are you sure to delete this Type ?</p>',
          onOk: async() => {
                    let obj ={
						type_id: type.id
					}
				const res = await this.callApi('post',`/category/deleteType/`, obj)

				if(res.status == 200){
					this.s('Category deleted successfully !!')
					this.types.data.splice(i, 1);
					this.types.total--
				}
          },

          onCancel: () => {

          }
      });
    },




	},

	async created () {
		this.alltypes()
	}
}
</script>


<style scoped>
._1card_top_search .ivu-input-wrapper{
	width:130%;
}
</style>
