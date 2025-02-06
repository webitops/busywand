<script setup>
import { cn } from '@/lib/utils';
import { Separator } from 'radix-vue';
import { computed } from 'vue';

const props = defineProps({
    orientation: { type: String, required: false },
    decorative: { type: Boolean, required: false },
    asChild: { type: Boolean, required: false },
    as: { type: null, required: false },
    class: { type: null, required: false },
    label: { type: String, required: false },
});

const delegatedProps = computed(() => {
    const { class: _, ...delegated } = props;

    return delegated;
});
</script>

<template>
    <Separator
        v-bind="delegatedProps"
        :class="
            cn(
                'relative shrink-0 bg-border',
                props.orientation === 'vertical'
                    ? 'h-full w-px'
                    : 'h-px w-full',
                props.class,
            )
        "
    >
        <span
            v-if="props.label"
            :class="
                cn(
                    'absolute left-1/2 top-1/2 flex -translate-x-1/2 -translate-y-1/2 items-center justify-center bg-background text-xs text-muted-foreground',
                    props.orientation === 'vertical'
                        ? 'w-[1px] px-1 py-2'
                        : 'h-[1px] px-2 py-1',
                )
            "
            >{{ props.label }}</span
        >
    </Separator>
</template>
