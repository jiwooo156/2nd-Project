<template>
    <section class="paging">
        <a class="pagingFirst" 
        @click = "prevPage()"
        :disabled = "page.page == 1">처음</a>
            <ul class="pagingList">
                <li 
                v-for = "item in countInPages" 
                :key = "item"
                :class = "(startPage-1)+item == page.page ? 'active' : null"
                @click = "selectPage( (startPage-1)+item )"
                > {{(startPage-1) + item}} </li>
            </ul>
        <a class="pagingLast" @click = "nextPage()">끝</a>
    </section>
</template>
<script>
export default {
    name: 'PagingView',
    props: {
        page: {
            type: Object,
            default () {
                return {
                    total: 354,
                    page: 32,
                    count: 10 
                }
            }
        },
        defaultPages: {
            type: Number,
            default: 10
        }
    },
    computed: {
        startPage: function () {
            let value = (Math.floor((this.page.page-1) / this.defaultPages) * this.defaultPages) + 1
            return value
        },
        totalPage: function () {
            var count = this.page.count ? this.page.count : 10
            return Math.floor(this.page.total / count) + ((this.page.total % count) == 0 ? 0 : 1)
        },
        countInPages: function () {
            let currPages = this.totalPage - (this.startPage-1)
            if (currPages < this.defaultPages) {
                return currPages
            } else {
                return this.defaultPages
            }
        }
    },
    methods: {
        selectPage: function (page) {
            this.$emit("onPage", page)
        },

        prevPage: function () {
            if (this.page.page == 1) {
                return
            }
            
            this.selectPage(this.page.page - 1)
        },

        nextPage: function () {
            if (this.page.page == this.totalPage) {
                return
            }
            
            this.selectPage(this.page.page + 1)
        }
    }
}
</script>