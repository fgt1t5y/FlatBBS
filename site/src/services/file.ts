import { alovaInstance } from './instance';
import { genForm } from '@/utils';
import type { UploadForm, UploadResult } from '@/types';

export const uploadFile = (files: File | File[]) => {
  const form = genForm<UploadForm>({
    avgfile: files,
  });

  return alovaInstance.Post<UploadResult>('/file/upload', form);
};
