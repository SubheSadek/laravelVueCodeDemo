<template>
    <span>

		<div class="_1card_top_right">
			<ul class="_1card_top_right_list">
				<li><template>
					<Button @click="createModalfunc" icon="md-add" type="primary">Add New</Button>
				</template></li>
			</ul>
		</div>

		<Modal v-model="createModal" draggable  class-name="vertical-center-modal" scrollable title="Create New Information Type">
			<div class="_login_form">
			  <Form>
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.type_name">
								<Input v-model="form.type_name"  @keyup.native="error.type_name=''" size="large" type="text" placeholder="Type name"/>
							</FormItem>
						</div>
					</div>
				</Form>
			</div>
			 <div slot="footer">
				<Button @click="addType" :loading="isLoading" :disabled="isLoading" icon="md-add" type="primary" >{{ isLoading ? 'Please wait . . .' : 'Add Type'}}</Button>
				<Button type="error" icon ="md-close" @click="createModal = false">Cancel</Button>
			</div>
		</Modal>
    </span>
</template>

<script>
export default {
	props:['type'],
	data(){
		return{
			createModal: false,
			isLoading:false,
			form:{
				type_name:''
			},

			error:{
				type_name:''
			},


		}
	},

	methods:{
		async addType() {

			this.clearDataError();

			let flag = 1

			if(!this.form.type_name  || this.form.type_name.trim()=='' || this.form.type_name==null){
				this.error.type_name ='Type name is required!'
				flag = 0
			}

			if(flag==0) return

			this.isLoading = true;

			const res = await this.callApi('post','/category/addType', this.form)

			if(res.status==200 || res.status==201){
				this.createModal=false
				this.s("Type created successfully!");
				this.type.total++
				this.type.data.unshift(res.data)
				this.clearData()
			}
			this.isLoading = false;

		},
		clearDataError() {
			this.error = {
				type_name:''
		   }
    	},
		clearData() {
			this.form = {
				type_name:''
			}
		},
		 createModalfunc(){
			this.clearData();
			this.createModal =true;
		 },



	}






}
</script>
<style scoped>
/* .ivu-btn[disabled]{
    background: #2d8cf0;
}

._1input_pass span{
	top: 2px;
}
._1input_pass span i{
	font-size: 18px;
} */

</style>
