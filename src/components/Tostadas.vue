<template>
	<div>
		<div class="position-fixed bottom-0 end-0 p-3 toast-container" style="z-index: 1051">
			<div id="tostadaBien" class="toast align-items-center text-white bg-primary" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="d-flex">
					<div class="toast-body">
						{{mensaje}}
					</div>
					<button type="button" class="btn-close  me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
			</div>
			<div id="tostadaMal" class="toast align-items-center text-white bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
				<div class="d-flex">
					<div class="toast-body">
						{{mensaje}}
					</div>
					<button type="button" class="btn-close  me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	name: 'Tostadas',
	props: ['mensaje']
}
</script>