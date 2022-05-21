<template>
	<div>
		<div class="_main_content">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12 _mar_b10">
					<Alert show-icon>
						<span style="font-weight:bold;">Tatal Database Backup File :{{types.length}}</span>
					</Alert>
				</div>
				<div class="col-12 col-md-12 col-lg-12">
					<div class="_box _b_radious3 _padd20">
						<div class="_1card_top _mar_b20">

							<div class="_1card_top_right">
                                <ul class="_1card_top_right_list">
                                    <li><template>
                                        <Button @click.native="instantBackup" :disabled="isBackup" :loading="isBackup" icon="md-cloud-download" type="primary">{{isBackup ? 'Please wait, it may take few seconds..' : 'Take instant backup'}}</Button>
                                    </template></li>
                                </ul>
                            </div>

						</div>
						<div class="_table_responsive">
							<Table class="" border :columns="columns1" :data="types">
									<template slot-scope="{row}" slot="cat_name">
										<p>database - {{row.file}}</p>
									</template>
									<template slot-scope="{row, index}" slot="action">
                                        <p>
										    <Button icon="md-cloud-download" type="primary" size="small" @click.native="download(row.file)">Download</Button>
										    <Button icon="ios-trash-outline" type="error" size="small" @click="deleteFile(row.file, index)">Delete</Button>
                                        </p>
									</template>
							</Table>
						</div>
						<div class="_pagination _padd_t20">
							<!-- <Page :total="types.total"  show-sizer :page-size-opts="pageOption" @on-page-size-change="getSizeChange"  @on-change="paginateDataInfo" /> -->
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
			isBackup:false,
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
    async instantBackup(){
        this.isBackup = true

        const res = await this.callApi('get', `/exel/db_backup`)
			if(res.status==200){
                let data = res.data;
                if(data.length > 0){
                    let file = data[0] ? data[0] :null;
                    this.types.unshift(file);
                    window.location.href = `${process.env.MIX_BASEURL}/exel/download_backup?file=${file.file}`;
                }

			}
        this.isBackup = false
    },
	async alltypes(){
		const res = await this.callApi('get', `/exel/show_backup`)
			if(res.status==200){
				this.types = res.data
			}
	},

	async download(file){
        window.location.href = `${process.env.MIX_BASEURL}/exel/download_backup?file=${file}`;
        // window.location.href = `${process.env.MIX_BASEURL}/exel/download_backup?file=${file}`;
	},
	async deleteFile(file, i){
        this.$Modal.confirm({
            title: 'Message',
            content: '<p>Are you sure to delete this Backup file ?</p>',
                onOk: async() => {
                    let obj = {
                        'file': file
                    }
                    const res = await this.callApi('post',`/exel/deleteBackup/`, obj)

                    if(res.status == 200){
                        this.s('Backup file deleted successfully !!')
                        this.types.splice(i, 1);
                    }
                },

                onCancel: () => {

                }
            });
        },
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

	async created () {
		this.alltypes()
        console.log("app url", process.env.MIX_BASEURL);
	}
}
</script>


<style scoped>
._1card_top_search .ivu-input-wrapper{
	width:130%;
}
</style>
