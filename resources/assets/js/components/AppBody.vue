<template>
    <div class="row">
        <div class="col-sm-12">
            <div class="row" style="margin-bottom: 15px">
                <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="fileLocation" placeholder="File Location"/>
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-primary width-100" v-on:click="loadFile">View</button>
                </div>
            </div>
            <div class="row" style="margin-bottom: 15px" v-if="!error">
                <div class="col-sm-12">
                    <div class="" v-if="logs.length > 0">
                        <div class="row" v-for="(log, index) in logs">
                            <div class="col-sm-2">
                                {{(pageNumber*10)+index + 1 }}
                            </div>
                            <div class="col-sm-10">
                                {{log}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 15px" v-if="showPagination">
                <div class="col-sm-12">
                    <div class="btn-group width-100" role="group" aria-label="...">
                        <button type="button" class="btn btn-default width-25" v-on:click="startOfFile">
                            <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-default width-25" v-on:click="previousPage">
                            <i class="fa fa-angle-left" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-default width-25" v-on:click="nextPage">
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                        </button>
                        <button type="button" class="btn btn-default width-25" v-on:click="endOfFile">
                            <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 15px" v-if="error">
                <div class="col-sm-12">
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Warning!</strong> {{errorMessage}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
    .width-100{
        width:100%;
    }
    .width-25{
        width:25%;
    }
</style>

<script>
    let _ = require('lodash');
    export default{
        data(){
            return{
                fileLocation:'',
                start: true,
                end: false,
                pageNumber: 0,
                logs : [],
                error : false,
                showPagination : false,
                errorMessage : ''
            }
        },
        methods: {

            viewFile(){

                this.error = false;
                this.errorMessage = '';
                let _this = this;

                window.axios.get(`/view-file`,{
                    params: {
                        location: this.fileLocation,
                        start: this.start,
                        end: this.end,
                        pageNumber: this.pageNumber
                    }
                }).then(function (response) {

                    if(response.data.status === 'success'){
                        _this.logs = response.data.logs;
                        _this.start = response.data.start;
                        _this.end = response.data.end;
                        _this.pageNumber = response.data.pageNumber;
                        _this.showPagination = true;
                        return true;
                    }
                    _this.error = true;
                    _this.showPagination = false;
                    _this.errorMessage = response.data.exception

                }).catch(function (error) {
                    _this.showPagination = false;
                    console.debug(error);
                });
            },

            startOfFile(){
                this.start = true;
                this.viewFile();
            },

            endOfFile(){
                this.end = true;
                this.viewFile();
            },

            nextPage(){
                this.pageNumber++;
                this.viewFile();
            },

            previousPage(){
                this.pageNumber--;
                this.viewFile();
            },

            loadFile(){
                this.logs = [];
                this.start = true;
                this.end = false;
                this.pageNumber = 0;
                this.viewFile();
            }

        }
    }
</script>