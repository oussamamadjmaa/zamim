<template>
    <div class="table-responsive">
        <table class="table table-borderless">
            <thead>
                <slot name="thead"></slot>
            </thead>
            <tbody>
                <slot></slot>
            </tbody>
        </table>
    </div>
</template>
