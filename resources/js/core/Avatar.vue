<template>
    <svg
        class="mercurius_avatar"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 200 200"
        :width="size"
        :height="size"
        :aria-labelledby="name">
        <title :id="name"></title>
        <defs>
            <path id="__avatarClipPath" d="M 181 140 C 187 128 190 114 190 100 C 190 50 150 10 100 10 C 50 10 10 50 10 100 C 10 150 50 190 100 190 C 114 190 128 187 140 181 C 135 176 132 169 132 161 C 132 145 145 132 161 132 C 169 132 176 135 181 140 Z"/>
            <clipPath id="avatarClipPath">
                <use xlink:href="#__avatarClipPath"/>
            </clipPath>
        </defs>
        <g clip-path="url(#avatarClipPath)">
            <path class="mercurius_avatar__bg" d="M0 0h500v500H0z"/>
            <image
                width="100%"
                height="100%"
                :xlink:href="image"/>
        </g>
        <use
            xlink:href="#__avatarClipPath"
            class="mercurius_avatar__border"
            :class="{online: is_online}"
            fill="transparent"
            :stroke-width="border"
            stroke-linejoin="round"/>
        <circle
            class="mercurius_avatar__status"
            :class="{online: is_online}"
            vector-effect="nonx-scaling-stroke"
            cx="160"
            cy="160"
            stroke-width="0"
            :r="radius"/>
    </svg>
</template>

<script>
export default {
    props: {
        name:      String,
        is_online: {type: [Boolean, Number], default: true},
        border:    {type: [Number, String], default: 4},
        radius:    {type: [Number, String], default: 10},
        size:      {type: [Number, String], default: 60},
        image:     {type: String, default: '/vendor/mercurius/img/avatar/avatar_placeholder.png'},
    },
}
</script>
