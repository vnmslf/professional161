import createBlobFromDataUri from './create-blob-from-data-uri';

const canvasPrototype = window.HTMLCanvasElement && window.HTMLCanvasElement.prototype;
const hasToBlobSupport = window.HTMLCanvasElement && canvasPrototype.toBlob;

const convertCanvasToBlob = (canvas: HTMLCanvasElement, type: string, quality: number): Promise<Blob> => {
	return new Promise((resolve, reject) => {
		if (canvas instanceof OffscreenCanvas)
		{
			canvas.convertToBlob({ type, quality }).then((blob: Blob) => {
				resolve(blob);
			});
		}
		else if (hasToBlobSupport)
		{
			canvas.toBlob((blob: Blob) => {
				resolve(blob);
			}, type, quality);
		}
		else
		{
			const blob = createBlobFromDataUri(canvas.toDataURL(type, quality));

			resolve(blob);
		}
	});
};

export default convertCanvasToBlob;