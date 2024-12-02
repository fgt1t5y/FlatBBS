import { alovaInstance } from './instance';
import { genForm } from '@/utils';
import type { Result, UploadForm } from '@/types';

export const uploadFile = (files: File | File[]) => {
  const form = genForm<UploadForm>({
    avgfile: files,
  });

  return alovaInstance.Post<Result<string[]>>('/file/upload', form);
};
