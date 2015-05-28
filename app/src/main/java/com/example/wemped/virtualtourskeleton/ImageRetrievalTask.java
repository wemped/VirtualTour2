package com.example.wemped.virtualtourskeleton;

import java.io.InputStream;
import java.net.URL;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;

/**
 * Created by wemped on 5/19/15.
 */
public class ImageRetrievalTask extends AsyncTask<String, Void, Bitmap> {
    ImageView Image;
    OnContentLoaded contentloader;
    public ImageRetrievalTask(ImageView theImage, OnContentLoaded loader) {
        this.Image = theImage;
        this.contentloader = loader;
    }
    @Override
    protected Bitmap doInBackground(String... urls) {

        String url = urls[0];
        Bitmap retrievedImage = null;

        try {
            InputStream is = new URL(url).openStream();
            retrievedImage = BitmapFactory.decodeStream(is);
        } catch (Exception e) {
            Log.e("Image Retrieval",e.getMessage());
            e.printStackTrace();
        }
        return retrievedImage;
    }

    protected void onPostExecute(Bitmap result) {
        Image.setAlpha(1f);
        /*Log.v("imageRT","width -> " + Image.getWidth());
        Log.v("imageRT","height -> " + Image.getHeight());*/

        //Image.setImageBitmap(ImageProcessor.decodeSampledBitmapFromResource(result, Image.getWidth(), Image.getHeight()));
        /*Not sure why, but height needs to be zero or else the size of the map will keep growing*/
        Image.setImageBitmap(ImageProcessor.decodeSampledBitmapFromResource(result, Image.getWidth(), 0));

        Image.setVisibility(View.VISIBLE);
        if (this.contentloader != null)
        {
            this.contentloader.onContentLoaded();
        }
    }

}
