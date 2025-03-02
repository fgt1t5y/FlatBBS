import { alovaInstance } from './instance';
import { genForm } from '@/utils';
import type { UploadForm } from '@/types';

export const uploadImage = (file: File) => {
  const form = genForm<UploadForm>({
    avgfile: file,
  });

  return alovaInstance.Put<string>('/file/image', form);
};
