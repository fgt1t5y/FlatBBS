import { alovaInstance } from './instance';
import { genForm } from '@/utils';
import type { UploadForm } from '@/types';

export const uploadFile = (file: File) => {
  const form = genForm<UploadForm>({
    avgfile: file,
  });

  return alovaInstance.Post<string>('/file/upload', form);
};
