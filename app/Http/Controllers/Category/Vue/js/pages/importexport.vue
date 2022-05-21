<template>
	<div>
		<div class="_main_content">
			<div class="row">
				<div class="col-12 col-md-12 col-lg-12 _mar_b10">
					<Alert show-icon>
						<span style="font-weight:bold;"> Import Informations : </span>
						<template slot="desc">Import All necessary Informations</template>
					</Alert>
				</div>
				<div class="col-12 col-md-12 col-lg-12">
					<div class="_box _b_radious3 _padd20">
						<div class="_1card_top _mar_b20">

							<div class="_1card_top_left">

								<div class="_1card_top_search">
									<span>Import Information : </span>
								</div>
								<div class="_1card_top_search">
									<!-- <input type="file" :value="file"> -->
                                    <input type="file"  name="info" ref="import_file"  @change="onFileChange">
								</div>
                                <Button @click.native="importInfo" :isloading="isLoading" :disabled="isLoading" icon="md-add" type="primary">{{isLoading ?'Please wait ...' : 'Import'}}</Button>
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>

	</div>
</template>

<script>

import _ from 'lodash';

export default {

	components: {
	},
	data () {
		return {
            info:'',
            isLoading:false,

		}
	},

	methods: {
        onFileChange(e) {
            this.info = e.target.files[0];
        },
        async importInfo(){
            if(this.info == '' || !this.info){
                this.i('Please, upload file first !');
                return;
            }
            let formData = new FormData();
            formData.append('info', this.info);
            this.isLoading = true;
            var self = this;

            const res = await this.callApi('post', `/exel/testSimpleExel`, formData);

            // setTimeout(function() {
            //   if(res.status == 200  || res.status == 201){
            //         self.s('Successfully imported !');
            //         window.location.reload();
            //     }
            //     self.isLoading= false;
            // }, 6000);

            // setTimeout(() => this.isLoading= false, 5000);
            if(res.status == 200  || res.status == 201){
                this.s('Successfully imported !');
            }
            this.isLoading= false;
        }


	},

	async created () {

	}
}
</script>


<style scoped>
._1card_top_search .ivu-input-wrapper{
	width:130%;
}
</style>
