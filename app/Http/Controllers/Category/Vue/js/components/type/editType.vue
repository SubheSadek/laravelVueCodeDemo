<template>
    <span>

        <Button @click="editModalfunc" icon="ios-create-outline" size="small" type="primary">Edit</Button>

		<Modal v-model="editModal" draggable  class-name="vertical-center-modal" scrollable title="Edit Type">
			<div class="_login_form">
			  <Form>
					<div class="row">
						<div class="col-12 col-md-12 col-lg-12">
							<FormItem :error="error.type_name">
								<Input v-model="form.type_name" @keyup.native="error.type_name=''" size="large" type="text" placeholder="Type name"/>
							</FormItem>
						</div>
					</div>
				</Form>
			</div>
			 <div slot="footer">
				<Button @click="editType" icon="ios-create-outline" :loading="isLoading" :disabled="isLoading" type="primary" >{{ isLoading ? 'Please wait . . .' : 'Edit'}}</Button>
				<Button type="error" icon ="md-close" @click="editModal = false">Cancel</Button>
			</div>
		</Modal>
    </span>
</template>

<script>
export default {
	props:['type'],
	data(){
		return{
			editModal: false,
			isLoading:false,
			form:{
                type_id:'',
				type_name:''
			},

			error:{
				type_name:''
			},


		}
	},

	methods:{
		async editType() {

			this.clearDataError();

			let flag = 1
			if(!this.form.type_name  || this.form.type_name.trim()=='' || this.form.type_name==null){
				this.error.type_name ='Type name is required!'
				flag = 0
			}

			if(flag==0) return

			this.isLoading = true;

			const res = await this.callApi('post','/category/editType', this.form)

			if(res.status==200 || res.status==201){
				this.editModal=false
				this.s("Type updated successfully!");
				this.Type.type_name = this.form.type_name;
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
		 editModalfunc(){
			this.form.type_id = this.type.id;
			this.form.type_name = this.type.type_name;
			this.editModal =true;
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
