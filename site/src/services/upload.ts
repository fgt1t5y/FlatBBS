import { requester } from './instance';
import { genForm } from '@/utils';
import type { UploadForm, UploadAs } from './interface';

export const upload = (file: File, as: UploadAs | undefined) => {
  const form = genForm<UploadForm>({
    avgfile: file,
    as: as,
  });

  return requester.post('/file/upload', form);
};

export const uploadAsAvatar = (avatarFile: File) => {
  return upload(avatarFile, 'avatar');
};
