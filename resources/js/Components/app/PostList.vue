<template>
    <div class="h-full flex-1 overflow-auto">
        <PostItem :post="post2" />
        <PostItem :post="post1" />
        <PostItem :post="post2" />

    </div>
</template>
<script setup>
import PostItem from "./PostItem.vue";
const post1 = {
    user: {
        id: 1,
        avatar: 'https://randomuser.me/api/portraits/men/86.jpg',
        name: "Dagem Gissila"
    },
    group: null,
    body: `<p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus quasi porro esse aliquam tempore 
        voluptates minima minus! Nostrum natus pariatur consequatur explicabo, hic a, quae praesentium laboriosam odio, adipisci modi!
 </p>
 <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus quasi porro esse aliquam tempore 
        voluptates minima minus! Nostrum natus pariatur consequatur explicabo, hic a, quae praesentium laboriosam odio, adipisci modi!
 </p>
 
 `,
    created_at: '2023-11-19 15:12',


}

const post2 = {
    user: {
        id: 1,
        avatar: 'https://randomuser.me/api/portraits/men/87.jpg',
        name: "Dagi Dagi"
    },
    group: {
        id:1,
        name:"Laravel Developer"
    },
    attachments:[
        {
            id:1,
            name:"test.png",
            url:"https://picsum.photos/1000",
            mime:"image/png"
        },
        {
            id:2,
            name:"test2.png",
            url:"https://picsum.photos/1000",
            mime:"image/png"
        },
        {
            id:3,
            name:"MyDocument.docx",
            url:"#",
            mime:"application/msword"
        },
    ],
    body: `<p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus quasi porro esse aliquam tempore 
        voluptates minima minus! Nostrum natus pariatur consequatur explicabo, hic a, quae praesentium laboriosam odio, adipisci modi!
 </p>
 <p> Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus quasi porro esse aliquam tempore 
        voluptates minima minus! Nostrum natus pariatur consequatur explicabo, hic a, quae praesentium laboriosam odio, adipisci modi!
 </p>
 
 `,
    created_at: '2023-11-19 15:12',


}
</script>
<style lang="">

</style>