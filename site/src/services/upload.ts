import { requester } from './instance';
import { genForm } from '@/utils';
import type { UploadForm } from './interface';

export const upload = (file: File) => {
  const form = genForm<UploadForm>({
    avgfile: file,
  });

  return requester.post('/file/upload', form);
};
